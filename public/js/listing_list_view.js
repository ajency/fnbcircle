(function() {
  var getListContent, getTemplateHTML;

  getTemplateHTML = function(templateToRender, data) {
    var htmlToRender, list, theTemplate, theTemplateScript;
    list = {};
    list['list'] = data;
    theTemplateScript = $("#" + templateToRender).html();
    theTemplate = Handlebars.compile(theTemplateScript);
    htmlToRender = theTemplate(list);
    return htmlToRender;
  };

  getListContent = function() {
    var data;
    data = {
      "page": 1,
      "page_size": 10,
      "sort_by": "published",
      "sort_order": "desc"
    };
    $.ajax({
      type: 'post',
      url: '/api/get-view-data',
      data: data,
      dataType: 'json',
      success: function(data) {
        var templateHTML;
        console.log(data);
        $(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"]);
        console.log(data["data"]);
        templateHTML = getTemplateHTML('listing_card_template', data["data"]);
        return $('#listing_card_view').append(templateHTML);
      },
      error: function(request, status, error) {
        return console.log(error);
      }
    });
  };

  $(document).ready(function() {
    $('#listing_card_view').empty();

    /* --- Custom If condition --- */
    Handlebars.registerHelper('ifCond', function(v1, v2, options) {
      if (v1 === v2) {
        return options.fn(this);
      } else {
        return options.inverse(this);
      }
    });
    Handlebars.registerHelper('ifLogic', function(v1, operator, v2, options) {
      switch (operator) {
        case '==':
        case '===':
        case 'is':
          if (v1 === v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '!=':
        case '!==':
          if (v1 !== v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '<':
          if (v1 < v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '<=':
          if (v1 <= v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '>':
          if (v1 > v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '>=':
          if (v1 >= v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '&&':
        case 'and':
          if (v1 && v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        case '||':
        case 'or':
          if (v1 || v2) {
            return options.fn(this);
          } else {
            return options.inverse(this);
          }
        default:
          return options.inverse(this);
      }
    });

    /* --- formatDate condition --- */
    Handlebars.registerHelper('formatDate', function(datetime, format, options) {
      var date_str, month_list;
      month_list = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
      date_str = new Date(datetime);
      return date_str.getDate() + " " + month_list[date_str.getMonth()] + " " + date_str.getFullYear();
    });
    getListContent();
  });

}).call(this);
