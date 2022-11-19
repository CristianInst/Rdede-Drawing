'use strict';

const { task, src, dest, series, watch } = require('gulp')
const sass        = require("gulp-sass")(require('sass'))
const cleanCSS = require('gulp-clean-css')
const rename = require('gulp-rename')
const uglify = require('gulp-uglify')
const babel = require('gulp-babel')
const fs = require('file-system')

const paths = {
    build: 'assets/build/',
    js: 'assets/js/',
    css: 'assets/css/',
    _root: 'assets/',
}

// Preprocess SASS
function buildSass(){
	return src(paths.css+'**/*.scss')
	.pipe(sass().on('error', sass.logError))
	.pipe(dest(paths.css))
    .pipe(cleanCSS({debug: true}, (details) => {
		console.log(`${details.name}: ${details.stats.originalSize} -> ${details.stats.minifiedSize}`);
	}))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(paths.build+'min/'))
}


function transpileJS(){
    return src(paths.js+'main.js')
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(uglify())
        .pipe(dest(paths.build+'/min'))
}



// Useful utils
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}




// WORDPRESS SPECIFIC //

function createBlock(cb){
    createRoutine('blocks')
    cb()
}
function removeBlock(cb){
    removeRoutine('blocks')
    cb()
}

function createComponent(cb){
    createRoutine('components')
    cb()
}
function removeComponent(cb){
    removeRoutine('components')
    cb()
}



function createRoutine(type){
    var param = [];
    let i = 0;
    const acceptedParam = [ '--name', '--desc', '--icon' ]
    acceptedParam.forEach(acc_param => {
        let name = acc_param.replace('--', '')
        i = process.argv.indexOf(acc_param)
        param[name] = ''
        if(i >= 0)
            param[name] = process.argv[i+1]
    })

    const { name, desc, icon } = param

    if(!name){
        console.log('you must provide param of --name to create a '+type)
    } else { 
        
        let blockParam = {
            dir: type+'/'+name,
            files: [name+'.php', 'index.scss', 'editor.scss']
        }
        if(type == 'components')
            blockParam.files.pop()

        if(!fs.existsSync(blockParam.dir)){
            console.log('creating '+type+':', name)

            fs.mkdirSync(blockParam.dir)
            blockParam.files.forEach(file => {
                let fileParts = file.split('.')
                fs.writeFileSync(blockParam.dir+'/'+file, initCode(type, fileParts[1], name), function(err){})
            })

            createLinks(type, name, desc, icon)

            console.log(type+' created, happy coding!')
        } else { console.log(type, 'already exists!') }
    }
}

function removeRoutine(type){
    let name, i = process.argv.indexOf('--name')
        name = process.argv[i+1]

    const blockParam = {
        dir: type+'/'+name,
        files: [name+'.php', 'index.scss', 'editor.scss']
    }
    if(name && fs.existsSync(blockParam.dir)){

        const requiredLinks = [ 
            'functions/functions-blocks.php', 
            'assets/css/main.scss', 
            'assets/css/editor.scss' 
        ]
        console.log('removing links')
        requiredLinks.forEach(link => {
            fs.readFile(link, 'utf-8', function(err, data){
                if(err) throw err;
    
                const fileParts = link.split('.')
                const initialFile = fileParts[0].split('/')
                
                if(type == 'blocks' && fileParts[1] == 'php'){
                    let value = data.split("\t\tgenerateBlock( '"+name.capitalize()+"', '"+name+"', ")
                    let nextValue = value[1].split(');\n')
                    nextValue.shift();
                    nextValue = nextValue.join(');\r')
                    let newValue = value[0] + nextValue;
                    fs.writeFile(link, newValue, 'utf-8', function(err){})
                    console.log('PHP: Link Removed!')
                }
    
                if(type != 'components' && initialFile[2] == 'editor'){
                    let value = data.split("@use '"+type+"/"+name+"/editor' as "+name+"-editor;\r\n")
                    let newValue = value[0] + value[1]
                    fs.writeFile(link, newValue, 'utf-8', function(err){})
                    console.log('SCSS: Editor Link Removed!')
                }
    
                if(initialFile[2] == 'main'){
                    let value = data.split("\r\n@use '"+type+"/"+name+"';")
                    let newValue = value[0] + value[1]
                    fs.writeFile(link, newValue, 'utf-8', function(err){})
                    console.log('SCSS: Main Link Removed!')
                }

    
            })
        })
        console.log('links removed!')



        if(fs.existsSync(blockParam.dir)){
            console.log('removing '+type+':', name)

            blockParam.files.forEach(file => {
                fs.unlink(blockParam.dir+'/'+file, function(err){})
            })
            fs.rmdir(blockParam.dir, function(err){})

            console.log(type+' removed, happy coding!')
        } else { console.log(type, 'does not exist!') }


    } else { console.log('you need to specify which block to remove') }
}

function initCode(type, fileType, name){
    var formatType = type.replace('s', '')
    switch(fileType){
        case 'php':
            return "<section "+(formatType == 'block' ? "id='<?php echo $block['id']; ?>' " : "")+"class='"+formatType+"--"+name+"'>\r\n\r\n</section>"
        case 'scss':
            return "@use '../../assets/css/config' as *; \r\n\r\n."+formatType+"--"+name+" {\r\n\r\n}"
    }
}


function createLinks(type, name, desc, icon){
    console.log('linking files')
    const requiredLinks = [ 
        'functions/functions-blocks.php', 
        'assets/css/main.scss', 
        'assets/css/editor.scss' 
    ]
    requiredLinks.forEach(link => {
        console.log('linking:', link)
        fs.readFile(link, 'utf-8', function(err, data){
            if(err) throw err;

            const fileParts = link.split('.')
            const initialFile = fileParts[0].split('/')

            if(type != 'components' && fileParts[1] == 'php'){
                let value = data.split('//[!GULP]')
                let newValue = value[0] + "//[!GULP]\r\n\t\tgenerateBlock( '"+name.capitalize()+"', '"+name+"', '"+desc+"', '"+icon+"' );" + value[1]
                fs.writeFile(link, newValue, 'utf-8', function(err){})
                console.log('PHP: Linked!')
            }

            if(type != 'components' && initialFile[2] == 'editor'){
                let newValue = "@use '"+type+"/"+name+"/editor' as "+name+"-editor;\r\n" + data
                fs.writeFile(link, newValue, 'utf-8', function(err){})
                console.log('SCSS: Editor Linked!')
            }

            if(initialFile[2] == 'main'){
                let value = data.split('/* - '+type.capitalize()+' */')
                let newValue = value[0]+ "/* - "+type.capitalize()+" */\r\n@use '"+type+"/"+name+"';" + value[1]
                fs.writeFile(link, newValue, 'utf-8', function(err){})
                console.log('SCSS: Main Linked!')
            }

        })
    })
}




exports.buildSass = buildSass;
exports.transpileJS = transpileJS;

exports.createBlock = createBlock;
exports.removeBlock = removeBlock;
exports.createComponent = createComponent;
exports.removeComponent = removeComponent;

exports.watch = function(){
    watch('**/*.scss', series(['buildSass']));
    watch(paths.js+'**/*.js', series(['transpileJS']));
}

exports.default = series(createBlock, createComponent)