$(".brand-label").change(function(){
        apply_filters()
     })

     function apply_filters(){
        var brands = [];
        $(".brand-label").each(function(){
            if($(this).is(":checked") == true){
                brands.push($(this).val())
            }
        })
        console.log(brands)
     }