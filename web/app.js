$(function() {
  var war;                      // store an interval ID here
  var channel = Math.random();  // store a unique ID for keeping track of this war

  // create a function to update the scores
  var updateScoreboard = function(army) {
    var id = army.army.replace(/ /g, '');
    var section = $('#scoreboard #' + id);
    if (! section.length) {
      $('#scoreboard').append('<div id="' + id + '" data-name="' + army.army + '" style="color: ' + army.color + '"></div>');
      section = $('#scoreboard #' + id);
    }

    section.text(army.troops);
  };

  // create a function to get latest updates
  var listenToChatter = function() {
    $.ajax({
      url: '/wageWar.php',
      data: { war: channel },
      dataType: 'json',
      success: function(json) {
        var update;
        
        $.each(json, function (i, data) {
          // creating HTML directly is ugly :\
          if (data.message) {
            update = '<b>' + data.army + ':</b> ' + data.message;

            var news = $('<div class="update" style="color: ' + data.color + '">' + update + '</div>');
            setTimeout(function() {
              news.hide().appendTo('#battlefield').fadeIn('slow');
            }, i * 500);
          } else if (data.surrendered) {
            // stop the war
            clearInterval(war);
          }

          // update the scores
          updateScoreboard(data);
        });
      },
      failure: function() {
        alert('There was an error starting the war! Guess we are stuck with peace.');
      }
    });
  };

  // start a war!
  war = setInterval(listenToChatter, 3000);
  
  // rush into battle!
  listenToChatter();
});

