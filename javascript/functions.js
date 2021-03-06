export function money(n) {
    try {
        const num = n.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return (n < 0) ? num.replace('-', '-$') : '$' + num;
    } catch (e) {
        console.error('error money', n);
        return n;
    }
}

function randomFromTo(min, max) {
  return Math.random() * (max - min) + min;
}

function chunk(size, array) {
  const result = [];

  while(array.length > 0){
    result.push(array.splice(0, size))
  }

  return result;
}

function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
      s4() + '-' + s4() + s4() + s4();
}

/**
 * <p onclick="copyToClip(this)">text</p>
 */
function copyToClip(e) {
  try {
    var range;
    var selection;

    if (document.body.createTextRange) {
      range = document.body.createTextRange();
      range.moveToElementText(e);
      range.select();
    } else if (window.getSelection) {
      selection = window.getSelection();
      range = document.createRange();
      range.selectNodeContents(e);
      selection.removeAllRanges();
      selection.addRange(range);
    }

    document.execCommand('copy');
  } catch (e) {}
};




function escapeHtml (string) {
  const entityMap = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;',
      '/': '&#x2F;',
      '`': '&#x60;',
      '=': '&#x3D;'
    };
  
    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
        return entityMap[s];
    });
}
