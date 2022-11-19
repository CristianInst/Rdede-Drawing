AOS.init({
    delay: 500,
    duration: 1000,
    once: true
})

jQuery(function(){
    
    jQuery('.mobile-menu-toggle').on('click', function(e){
        e.preventDefault()
        jQuery(this).toggleClass('active')
        jQuery('.menu-header-container').toggleClass('active')
    })


    // Video playback
    jQuery('.media--container[data-type="video"]').attr('data-status', 'initial')
    jQuery('.media--container[data-type="video"] span').on('click', function(){
        const parent = jQuery(this).parent()
        if(jQuery(parent).attr('data-status') === 'playing'){
            jQuery('video', parent).get(0).pause()
            jQuery(parent).attr('data-status', 'paused')
        } else {
            jQuery('video', parent).get(0).play()
            jQuery(parent).attr('data-status', 'playing')
        }
    })

    
    if(jQuery('.block--listing'))
        jQuery('.block--listing .listing--wrapper').slick({
            autoplay: false,
            infinite: false,
            dots: true,
            arrows: false,
            speed: 450,
            responsive: [
                {
                    breakpoint: 9999,
                    settings: "unslick"
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
            ]
        })




    //Cookie policy
    if(localStorage.getItem('cookie'))
        jQuery('#cookie').remove()

    jQuery('#cookie button').on('click', function(e){
        e.preventDefault()
        localStorage.setItem('cookie', 1)
        jQuery('#cookie').toggleClass('accepted pending')
    })



//This code changes the title of the application form for each role applied for. 
//While this is a feature I have only commented this code out rather than deleting
//I have left this code in as it maybe useful for changing the title of froms on different sites
    // if(jQuery('.component--application-form'))
    //     jQuery('.job_role input').attr('value', jQuery('.the--role h1').text())


    // jQuery('.component--application-form i.fa-times-circle').on('click', function(){
    //     jQuery(this).parent().toggleClass('open')
    // })
})