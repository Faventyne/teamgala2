$(function() {
        $("#add_criterion_form_gradetype_1").on("click",function(){

            $('#add_criterion_form_lowerbound').parent().hide();
            $('#add_criterion_form_upperbound').parent().hide();
            $('#add_criterion_form_step').parent().attr("class","button-field col s10 m5");
        });

        $("#add_criterion_form_gradetype_0").on("click",function(){

            $('#add_criterion_form_step').parent().attr("class","button-field col s5 m3");
            $('#add_criterion_form_lowerbound').parent().show();
            $('#add_criterion_form_upperbound').parent().show();

        });


        }


);