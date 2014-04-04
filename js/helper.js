function empty(s){
	if ($.trim(s)=="") return true; else return false;
}
function strrpos (haystack, needle, offset) {
  var i = -1;
  if (offset) {
	i = (haystack + '').slice(offset).lastIndexOf(needle); // strrpos' offset indicates starting point of range till end,
	// while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
	if (i !== -1) {
	  i += offset;
	}
  } else {
	i = (haystack + '').lastIndexOf(needle);
  }
  return i >= 0 ? i : false;
}
function invalidImage(imageName){
	if (imageName=="") return true;		
	var fileExtension=imageName.substring( strrpos(imageName, '.') + 1 ).toLowerCase();	
	if ( (fileExtension!="jpg") && (fileExtension!="png") && (fileExtension!="gif") ) return true;
	else return false;	
}
