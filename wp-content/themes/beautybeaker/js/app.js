$(document).ready(function(){

    $(".rslides").responsiveSlides({
        nav: true,   
        pager: true, 
    });

    $("#banner .next").html("<i class='fas fa-chevron-right'></i>")
    $("#banner .prev").html("<i class='fas fa-chevron-left'></i>")
    $("#banner .rslides_tabs li a").html("")
    

    let shown = false;
    $(".mobileClose").click(function(){
        $(".main_nav").removeClass("navfixed")
    })

    $(".mobileBar a").click(function(){
        $(".main_nav").addClass("navfixed")
    })

    let winWid = $(window).width();

    const resizeWindowCallBack = () => {
        winWid = $(window).width();
        // if(winWid <= 800){
        //     $(".main_nav").addClass("navfixed")
        // }else{
        //     $(".main_nav").removeClass("navfixed")
        // }
        
    }

    $(window).resize(resizeWindowCallBack)

    resizeWindowCallBack()

    // accourdion
    $(".acc_sect .accordion").click(function(){
        if(!$(this).closest(".acc_sect").hasClass("active")){
            acc_callback();
            $(this).closest(".acc_sect").addClass("active")
            $(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up")
        }
        else{
            acc_callback();
        }
    })

    const acc_callback = () => {
        $(".acc_sect").removeClass("active")
        $(".acc_sect i").removeClass("fa-chevron-up").addClass("fa-chevron-down")
    }
    // end accordion
})