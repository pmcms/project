// Wait for the DOM to be ready
$(function() {

  $.validator.addMethod(
      "formatDate",
      function(value, element) {
          // put your own logic here, this is just a (crappy) example
          return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
      },
      "กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy."
  );

  $.validator.addMethod(
      "formatTime",
      function(value, element) {
          // put your own logic here, this is just a (crappy) example
          return value.match(/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/);
      },
      "กรุณากรอกเวลาในรูปแบบ hh:mm"
  );
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      projectname: {
        required : true,
      },
      startdate: {
        required : true,
        formatDate : true,
      },
      starttime: {
        required : true,
        formatTime : true,
      },
      stopdate: {
        required : true,
        formatDate : true,
      },
      stoptime: {
        required : true,
        formatTime : true,
      },
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    // Specify validation error messages
    messages: {
        projectname: "กรุณากรอกชื่อโครงการ",
        startdate: {
          required : "กรุณากรอกวันที่",
          formatDate : jQuery.validator.format("กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy"),
        },
        stopdate: {
          required : "กรุณากรอกวันที่",
          formatDate : jQuery.validator.format("กรุณากรอกวันที่ในรูปแบบ dd/mm/yyyy"),
        },
        starttime:  {
          required : "กรุณากรอกวันที่",
          formatTime : jQuery.validator.format("กรุณากรอกเวลาในรูปแบบ hh:mm"),
        },
        stoptime: {
          required : "กรุณากรอกวันที่",
          formatTime : jQuery.validator.format("กรุณากรอกเวลาในรูปแบบ hh:mm"),
        },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});