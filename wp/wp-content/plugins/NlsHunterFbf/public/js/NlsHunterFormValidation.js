var FormValidator =
  FormValidator ||
  (function ($) {
    "use strict";

    var Validators = {
      ISRID: {
        fn: function (value) {
          // DEFINE RETURN VALUES
          var R_ELEGAL_INPUT = false; // -1
          var R_NOT_VALID = false; // -2
          var R_VALID = true; // 1

          //INPUT VALIDATION

          // Just in case -> convert to string
          var IDnum = String(value);

          // Validate correct input (Changed from 5 to 9 so only 9 digits are allowed)
          if (IDnum.length > 9 || IDnum.length < 9) return R_ELEGAL_INPUT;
          if (isNaN(IDnum)) return R_ELEGAL_INPUT;

          // The number is too short - add leading 0000
          if (IDnum.length < 9) {
            while (IDnum.length < 9) {
              IDnum = "0" + IDnum;
            }
          }

          // CHECK THE ID NUMBER
          var mone = 0,
            incNum;
          for (var i = 0; i < 9; i++) {
            incNum = Number(IDnum.charAt(i));
            incNum *= (i % 2) + 1;
            if (incNum > 9) incNum -= 9;
            mone += incNum;
          }
          if (mone % 10 == 0) return R_VALID;
          else return R_NOT_VALID;
        },
        msg: "מספר הזהות לא חוקי",
      },

      email: {
        fn: function (value) {
          var regex =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return value && regex.test(String(value).toLowerCase());
        },
        msg: "כתובת האימייל לא חוקית",
      },

      phone: {
        fn: function (value) {
          var regex = /^0[0-9]{1,2}[-\s]{0,1}[0-9]{3}[-\s]{0,1}[0-9]{4}/i;
          return value && regex.test(String(value).trim().toLowerCase());
        },
        msg: "מספר הטלפון לא חוקי",
      },

      required: {
        fn: function (value) {
          return value && value.length > 0;
        },
        msg: "שדה זה הוא שדה חובה",
      },

      // If no option was selected of radi will return false
      radioRequired: {
        fn: function (el) {
          var valid = false;
          var name = $(el).attr("name");
          if (typeof name === "undefined") return valid;

          $(el)
            .parents(".nls-field")
            .find('input[name="' + name + '"]')
            .each(function (i, option) {
              if ($(option).prop("checked")) valid = true;
            });
          return valid;
        },
        msg: "יש לבחור אחת מהאפשרויות",
      },
    };

    var validateForm = function (form) {
      clearValidation(form);
      var valid = true;

      $(form)
        .find("input")
        .each(function (i, el) {
          // If hidden
          if ($(el).parents().css("display") === "none")
            return;
          if (typeof $(el).attr("validator") === "undefined") return;
          if (!fieldValidate(el)) valid = false;
        });
      console.log("Valid: ", valid);
      validForm();
      return valid;
    };

    var validForm = function (form) {
      var invalidFields = $(form).find(".nls-invalid");
      if (invalidFields.length > 0) {
        $(form).find(".form-footer .help-block")
          .text("אחד או יותר משדות הטופס לא תקין")
          .show();
      } else {
        $(form).find(".form-footer .help-block").hide();
        $(form).find(".help-block").text("");
      }
    };

    // Validates all of the field validators
    var fieldValidate = function (el) {
      var valid = true;
      var validatorAttr = $(el).attr("validator");
      var validators = validatorAttr.trim().split(" ");
      var type = $(el).attr("type");
      var value = type === "radio" ? el : $(el).val();

      validators.forEach(function (validator) {
        if (!validator || validator.length === 0) return;
        // If invalid skip (show only first error)
        if ($(el).hasClass("nls-invalid")) return;

        if (!Validators[validator].fn(value)) {
          valid = false;
          var invalidElement =
            type === "radio" ? $(el).parents(".options-wrapper") : $(el);

          $(invalidElement).addClass("nls-invalid");
          $(el)
            .parents(".nls-field")
            .find(".help-block")
            .text(Validators[validator].msg);
        }
      });
      return valid;
    };

    var clearFields = function (form) {
      $(form).find('input:not([type="radio"],[type="hidden"])').val("");
      $(form).find('select.sumo').each(function () {
        $(this)[0].sumo.unSelectAll();
      });
      clearValidation(form);
    };

    var clearValidation = function (form) {
      $(form).find(".nls-invalid").removeClass("nls-invalid");
      $(form).find(".nls-field .help-block").text("");
      validForm();
    };

    var clearFieldValidation = function (el) {
      $(el)
        .parents(".nls-field")
        .find(".nls-invalid")
        .removeClass("nls-invalid");
      $(el).parents(".nls-field").find(".help-block").text("");
    };

    var getParam = function (param) {
      var queryString = window.location.search;
      var urlParams = new URLSearchParams(queryString);
      return urlParams.get(param);
    };

    $(document).ready(function () {
      // Add event listeners
      console.log("Validator Init");

      // Add file indication when selected
      $(document).on("change", '.nls-form input[type="file"]', function (e) {
        if ($(this).val().length > 0) {
          $(this).parent().find('label').addClass('file-selected');
        } else {
          $(this).parent().find('label').removeClass('file-selected');
        }
      });

      // Clear validation errors on focus
      $(document).on("focus", ".nls-form input", function () {
        clearFieldValidation(this);
      });

      // Validate on blur and change
      $(document).on('blur change', '.nls-form input:not([type="radio"])', function () {
        if (typeof $(this).attr("validator") === "undefined") return;
        clearFieldValidation(this);
        fieldValidate(this);
        validForm();
      });

      // Toggle visibility of radio
      $(document).on("change", '.nls-form input[type="radio"]', function () {
        var showClass = ".nls-field." + $(this).attr("name") + "-show";
        $('input[name="' + $(this).attr("name") + '"]').prop("checked")
          ? $(showClass).show()
          : $(showClass).hide();
      });

      // Make sure to initilize the radio display options
      $('.nls-form input[type="radio"]').trigger("change");
    });

    return {
      clearFields: clearFields,
      clearValidation: clearValidation,
      validateForm: validateForm
    };
  })(jQuery);
