
 function sandsBaloon(controlID, popupID)
 {
  $(controlID).click(function() {
    var buttonOffset = $(this).offset();
    var popupLeft = buttonOffset.left;
    var popupTop = buttonOffset.top + $(this).outerHeight();

    $(popupID).css({
      'position': 'absolute',
      'left': popupLeft + 'px',
      'top': popupTop+5 + 'px',
    });

    $(popupID).show();
  });
}


