const setSpanish = () => {
    // console.log("Set spanish");
    setTimeout(() => {
      if (!localStorage.getItem("lang-data")) {
        $(".flags.default").click();
      }
    }, 5000);
  };
  $(document).ready(function (e) {
    checkLanguage();

    // $(window).on("load", setSpanish);

    function checkLanguage() {
      if (localStorage.getItem("lang-data")) {
        let lang = localStorage.getItem("data-lang");
        let langCode = localStorage.getItem("data-lang-code");
        let langSrc = localStorage.getItem("src");
        $(".selected-flag").attr("src", langSrc);
        $(".selected-flag").attr("data-lang", lang);
        $(".selected-flag").attr("data-lang-code", langCode);
        $("body").removeClass();
        $("body").addClass(`lang_${langCode} lang_${lang}`);
        $("#google_translate_element1 select option").each(function () {
          if ($(this).text().indexOf(lang) > -1) {
            $(this).parent().val($(this).val());
            var container = document.getElementById("google_translate_element1");
            var select = container.getElementsByTagName("select")[0];
            triggerHtmlEvent(select, "change");
          }
        });

        setTimeout(() => {
          $("body").removeAttr("style");
        }, 5000);
      } else {
        let spElement = $(".flags.default");
        let lang = "English";
        let langCode = "en";
        let langSrc = spElement.attr("src");
        $(".selected-flag").attr("src", langSrc);
        $(".selected-flag").attr("data-lang", lang);
        $(".selected-flag").attr("data-lang-code", langCode);
        $("body").removeClass();
        $("body").addClass(`lang_${langCode} lang_${lang}`);
        $("#google_translate_element1 select option").each(function () {
          if ($(this).text().indexOf(lang) > -1) {
            $(this).parent().val($(this).val());
            var container = document.getElementById("google_translate_element1");
            var select = container.getElementsByTagName("select")[0];
            triggerHtmlEvent(select, "change");
          }
        });

        setTimeout(() => {
          $("body").removeAttr("style");
        }, 5000);
      }
    }

    $("body").on("click", ".flags", function () {
      // console.log("click called");
      let src = $(this).attr("src");
      let lang = $(this).data("lang");
      let langCode = $(this).data("lang-code");
      $(".selected-flag").attr("src", src);
      $(".selected-flag").attr("data-lang", lang);
      $(".selected-flag").attr("data-lang-code", langCode);
      localStorage.setItem("data-lang", lang);
      localStorage.setItem("data-lang-code", langCode);
      localStorage.setItem("src", src);
      localStorage.setItem("lang-data", true);

      $("body").removeClass();
      $("body").addClass(`lang_${langCode} lang_${lang}`);
      $("#google_translate_element1 select option").each(function () {
        if ($(this).text().indexOf(lang) > -1) {
          $(this).parent().val($(this).val());
          var container = document.getElementById("google_translate_element1");
          var select = container.getElementsByTagName("select")[0];
          triggerHtmlEvent(select, "change");
        }
      });
    });

    function triggerHtmlEvent(element, eventName) {
      var event;
      if (document.createEvent) {
        event = document.createEvent("HTMLEvents");
        event.initEvent(eventName, true, true);
        element.dispatchEvent(event);
      } else {
        event = document.createEventObject();
        event.eventType = eventName;
        element.fireEvent("on" + event.eventType, event);
      }

      setTimeout(() => {
        $("body").removeAttr("style");
      }, 2000);
    }

    $("body").on("click", ".za-nav-list", function () {
      $(".za-nav-dropdown").fadeToggle(500);
    });
  });
