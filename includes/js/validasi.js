/*
Author: phitias@gmail.com
*/
var r={
	'special':/[\W]/g,
	'quotes':/['\''&'\"']/g,
	'numbers':/[^\d & '\.' & '\,']/g,
	'year':/[^\d]/g
}

function valid(o,w){
	o.value = o.value.replace(r[w],'');
}