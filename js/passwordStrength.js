$(document).ready(function(){
var state1="";
var state2="";
var state3="";
$('#password').on('keyup', function () {
    var password = $(this);
    var pass = password.val();
    var passLabel = $('[for="password"]');
    var stength;
    var pclass;
    if(pass == '') {
        stength = 'Enter Password...';
        state1="";
        state2="";
        state3="";
    } else {
        for(var i=0; i< pass.length; i++)
        {
            characterCode=pass.charCodeAt(i);
            if((characterCode>=65 && characterCode<=90) || (characterCode>=97 && characterCode<=122))
            {
                state1="a";
            }
            else if(characterCode>=48 && characterCode<=57)
            {
                state2="n";
            }
            if((characterCode>=33 && characterCode<=47) || (characterCode>=58 && characterCode<=64) || (characterCode>=91 && characterCode<=96) || (characterCode>=123 && characterCode<=248))
            {
                state3="o";
            }
            if(state1=="a" && state2=="n" && state3=="o")
            {
                stength = 'Strong';
                pclass = 'success';
            }
            else if((state1=="a" && state3=="o") || (state1=="a" && state2=="n") || (state2=="n" && state3=="o"))
            {
                stength = 'Moderate';
                pclass = 'warning';
            }
            else if(state1=="a" || state2=="n" || state3=="o")
            {
                stength = 'Weak';
                pclass = 'danger';
            }
        }
    }
    
    // if (best.test(pass) == true) {
    //     stength = 'Strong';
    //     pclass = 'success';
    // } else if (good.test(pass) == true) {
    //     stength = 'Moderate';
    //     pclass = 'warning';
    // } else if (bad.test(pass) == true) {
    //     stength = 'Weak';
    //     pclass = 'danger';

    // } else {
    //     stength = 'Weak';
    // }

    var popover = password.attr('data-content', stength).data('bs.popover');
    popover.setContent();
    popover.$tip.addClass(popover.options.placement).removeClass('danger success info warning primary').addClass(pclass);

});

$('input[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'focus'
});

})