function countLines(strtocount, cols) {
  var hard_lines = 1;
  var last = 0;
  while ( true ) {
    last = strtocount.indexOf("\n", last+1);
    hard_lines ++;
    if ( last == -1 ) break;
  }
  var soft_lines = Math.round(strtocount.length / (cols-1));
  var hard = eval("hard_lines  " + unescape("%3e") + "soft_lines;");
  if ( hard ) soft_lines = hard_lines;
  return soft_lines;
}

function cleanForm() {
  for(var no=0;no<document.forms.length;no++){
    var the_form = document.forms[no];
    for( var x in the_form ) {
      if ( ! the_form[x] ) continue;
      if( typeof the_form[x].rows != "number" ) continue;

      if(!the_form[x].onkeyup) {the_form[x].onkeyup=function()
      {this.rows = countLines(this.value,this.cols)+1;};the_form[x].rows =
      countLines(the_form[x].value,the_form[x].cols) +1;}
    }
  }
}

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
  cleanForm();
});

