$('body').on('keydown', 'input , #exampleModal , select , textarea ', function (e) {

    if (e.key === "Enter") {
        e.preventDefault();
     
        // $('#exampleModal').modal('hide');

        // console.log('gya');
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input:not([readonly])').filter(':visible');
        next = focusable.eq(focusable.index(this) + 1);
       
        if (next.length) {
            next.focus();
            next.select();
            next.trigger('click');

        } else {
            next.focus();
            // form.submit();


        }
        return false;
    }
    else if (e.which == "37") {
        e.preventDefault();
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input:not([readonly])').filter(':visible');
        next = focusable.eq(focusable.index(this) - 1);
        if (next.length) {
            next.focus();
            next.select();
            next.trigger('click');

        }
        return false;
    }
    else if (e.which == "38") {
        e.preventDefault();
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input:not([readonly])').filter(':visible');
        var all_bags = $(".bagheadings");
        // console.log(all_bags);
        if(all_bags.length!=0){
        if (all_bags[0].style.display == "none") {
            next = focusable.eq(focusable.index(this) - 4);
        }
        else {

            next = focusable.eq(focusable.index(this) - 8);
        }}
        else{
            next = focusable.eq(focusable.index(this) - 6); 
        }
        if (next.length) {
            next.focus();
            next.select();

            next.trigger('click');
        }
        return false;
    }
    else if (e.which == "39") {
        e.preventDefault();
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input:not([readonly])').filter(':visible');
        next = focusable.eq(focusable.index(this) + 1);
        if (next.length) {
            next.focus();
            next.select();

            next.trigger('click');
        }
        return false;
    }
    else if (e.which == "40") {
        e.preventDefault();
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input:not([readonly])').filter(':visible');
        var all_bags = $(".bagheadings");
        if(all_bags.length!=0){
        if (all_bags[0].style.display == "none") {
            next = focusable.eq(focusable.index(this) + 4);
        }
        else {

            next = focusable.eq(focusable.index(this) + 8);
        }}
        else{
            next = focusable.eq(focusable.index(this) + 6); 
        }
        if (next.length) {
            next.focus();
            next.select();
            
            next.trigger('click');
        }else{
            focusable[0].focus();
            focusable[0].select();
            focusable[0].trigger('click');
        }
        return false;
    }

    


});