# Janus
Authenticity WordPress Master theme for Rdede-Drawing

## GULP Setup
Run the following commands in terminal when you're in the this theme's directory:
- npm i gulp gulp-clean-css gulp-rename gulp-sass gulp-babel gulp-uglify
- npm i @babel/core @babel/preset-env
Then use `gulp watch` to start watching the scss files

## GULP Add-on
Integrated with this, the most recent gulpfile, is the ability to create WP blocks (must be noted this is contingent on certains paths which need to be looked at to fully understand).
Essentially the developer can use cli to execute functions that will do the necessary leg work to create a block without the need to do anything. This makes it much easier and faster to do than previously.

`gulp createBlock --name gallery --desc "This is a gallery block" --icon image`

The above command will create a gutenberg block and setup the files necessary for it's development. This command above is the actual command in full with params where `--icon` is a dash icon.

`gulp removeBlock --name gallery`

The above command will remove the necessary block in its entirey and leave not lines of code. Caution must be used with this as there's no way to undo other than to pull it back from version control if it was uploaded

## Plugins

- ACF Pro
- Autoptimize
- Better Search Replace
- WP Migrate DB
- Yoast SEO

## Blocks
This theme **requires** the use of a content block, do not add content to pages without putting it into this block. This is due to the flexibility of the content itself needing to flow to the edgess of the browser window (i.e background colours in containers).


## Mainbtenance Mode
This theme has a custome function for Maintenance mode. This will hide a page while it is undergoing maintenance, allowing only adminstrators to see the page. To be able to turn this fucntion on and off you need to add this code to wp-config.php.

`define('IN_MAINTENANCE', true);`

The layout and design of the maintennce mode page can be changed in the maintenance.php file found in this theme. 