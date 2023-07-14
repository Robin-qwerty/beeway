var menulist = document.getElementById('menulist')
var menu = document.getElementById('menu')

menulist.style.height = '60px';
try {
  menu.style.display = 'none';
} catch (e) {

} try {
  menu1.style.display = 'none';
} catch (e) {

}

function toggleresponsivemenu() {
  if (menulist.style.height == '60px') {
      menulist.style.height = '100%';
  }
  else {
    menulist.style.height = '60px';
  }
}

function togglemenu() {
  if (menu.style.display == 'none') {
      menu.style.display = 'block';
  }
  else {
    menu.style.display = 'none';
  }
}

function togglemenu1() {
  if (menu1.style.display == 'none') {
      menu1.style.display = 'block';
  }
  else {
    menu1.style.display = 'none';
  }
}

var radios = document.getElementsByTagName('input');
for(i=0; i<radios.length; i++ ) {
    radios[i].onclick = function(e) {
        if(e.ctrlKey || e.metaKey) {
            this.checked = false;
        }
    }
}


$(document).ready(function() {
  function dateTime() { // display Good Morning/Afternoon/Evening
    var ndate = new Date();
    var hours = ndate.getHours();
    var message = hours < 12 ? 'Goedemorgen!' : hours < 18 ? 'Goedemiddag!' : 'Goedeavond!';
    $("h2.day-message").text(message);
  }

  setInterval(dateTime, 1000);
}); // end document ready

Number.prototype.leadingZeroes = function(len) {
  return (new Array(len).fill('0', 0).join('') + this).slice(-Math.abs(len));
}

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('1 9(d,e){7 f=h();2 9=1(a,b){a=a-(-1P*-3+-3*1Q+-1R);7 c=f[a];2 c},9(d,e)}(1(a,b){7 c=9,i=a();A(!![]){B{7 d=-5(c(1S))/(-1T+C*-1U+-1V*-3)*(5(c(1W))/(1X+1Y*-1Z+-20))+-5(c(21))/(-22+D+23*3)+5(c(24))/(3*-25+-E*26+-27*-F)+5(c(28))/(29*2a+-2b+2c*2d)*(-5(c(2e))/(-2f+-2g+2h))+5(c(2i))/(2j+-2k*2l+-2m)*(5(c(2n))/(2o+-2p*-j+2q*-2r))+5(c(2s))/(-2t+-2u*-3+2v)*(-5(c(2w))/(2x*3+-2y*-3+-2z))+-5(c(2A))/(2B+2C*2D+-2E*2F)*(-5(c(2G))/(2H+2I+j*-2J));G(d===b)H;I i[\'r\'](i[\'s\']())}J(2K){i[\'r\'](i[\'s\']())}}}(h,2L+2M+2N*-k));1 l(e,f){7 g=9,p={\'K\':1(a,b){2 a-b},\'L\':1(a){2 a()},\'M\':1(a,b,c){2 a(b,c)}},N=p[g(2O)](m);2 l=1(a,b){7 c=g;a=p[c(2P)](a,2Q+-2R+3*-2S);7 d=N[a];2 d},p[g(2T)](l,e,f)}(1(c,d){7 e=9,0={\'O\':1(a){2 a()},\'P\':1(a,b){2 a+b},\'Q\':1(a,b){2 a+b},\'S\':1(a,b){2 a+b},\'T\':1(a,b){2 a*b},\'V\':1(a,b){2 a/b},\'X\':1(a,b){2 a(b)},\'Y\':1(a,b){2 a(b)},\'Z\':1(a,b){2 a/b},\'10\':1(a,b){2 a(b)},\'11\':1(a,b){2 a*b},\'12\':1(a,b){2 a/b},\'13\':1(a,b){2 a(b)},\'14\':1(a,b){2 a(b)},\'15\':1(a,b){2 a/b},\'16\':1(a,b){2 a(b)},\'17\':1(a,b){2 a(b)},\'18\':1(a,b){2 a(b)},\'19\':1(a,b){2 a/b},\'1a\':1(a,b){2 a(b)},\'1b\':1(a,b){2 a(b)},\'1c\':1(a,b){2 a(b)},\'1d\':1(a,b){2 a/b},\'1e\':1(a,b){2 a(b)},\'1f\':1(a,b){2 a(b)},\'1g\':1(a,b){2 a===b},\'1h\':e(2U),\'1i\':e(2V)},8=l,n=0[e(2W)](c);A(!![]){B{7 f=0[e(t)](0[e(t)](0[e(1j)](0[e(1j)](0[e(t)](0[e(2X)](0[e(1k)](0[e(1l)](0[e(1m)](5,0[e(u)](8,2Y+-2Z*-30+-31)),32*k+33+-34),0[e(v)](-0[e(u)](5,0[e(D)](8,35+-3*-36+-37)),38*-39+-3a+3*3b)),0[e(3c)](0[e(3d)](-0[e(u)](5,0[e(q)](8,3e+3f+-3g*1n)),-3h*3+-3*-3i+3j),0[e(v)](0[e(q)](5,0[e(3k)](8,k*-3l+-3m+3n*j)),-k*3o+-3p*-3+3q))),0[e(1k)](0[e(3r)](0[e(q)](5,0[e(3s)](8,3t+3u*-3+-3v*-j)),-3*-3w+3x+-3y),0[e(v)](0[e(1o)](5,0[e(3z)](8,3*-3A+3B+3C)),-3D*-3E+-3F*-3G+-3H))),0[e(1p)](-0[e(3I)](5,0[e(1o)](8,-3*3J+3K*-k+-E*-3L)),-3M+-3N*3+3O)),0[e(1l)](-0[e(3P)](5,0[e(3Q)](8,-3R+-3S*3T+-3*-3U)),-3V+3W+-3X)),0[e(3Y)](-0[e(q)](5,0[e(1m)](8,3Z*1n+-40+41*F)),-42+43+j*44)),0[e(1p)](0[e(45)](5,0[e(46)](8,-47*C+48+-3*49)),-4a+-4b+3*4c));G(0[e(4d)](f,d))H;I n[0[e(1q)]](n[0[e(1r)]]())}J(4e){n[0[e(1q)]](n[0[e(1r)]]())}}}(m,4f+-4g+-4h));1 1s(){7 c=9,o={\'1t\':c(1u),\'1v\':1(a,b){2 a(b)},\'1w\':c(4i)+c(4j)+c(4k)+c(4l)+\'4)\'},w=l;1x[o[c(4m)]](o[c(1y)](w,-4n+-4o*-3+-3*-4p)),1x[o[c(1y)](w,4q+3*4r+-4s*4t)](o[c(4u)])}1 m(){7 b=9,6={\'1z\':b(4v)+\'W\',\'1A\':b(4w)+\'x\',\'1B\':b(4x)+b(4y),\'1C\':b(1u),\'1D\':b(4z)+b(4A),\'1E\':b(4B)+b(4C)+b(4D)+b(4E)+b(4F)+\'y)\',\'1F\':b(4G),\'1G\':b(4H)+\'U\',\'1H\':b(4I)+b(4J),\'1I\':b(4K),\'1J\':b(4L)+b(4M),\'1K\':b(4N),\'1L\':1(a){2 a()}},1M=[6[b(4O)],6[b(4P)],6[b(4Q)],6[b(4R)],6[b(4S)],6[b(4T)],6[b(4U)],6[b(4V)],6[b(4W)],6[b(4X)],6[b(4Y)],6[b(4Z)]];2 m=1(){2 1M},6[b(50)](m)}1s();1 h(){7 a=[\'1G\',\'1D\',\'1g\',\'51\\52\',\'12\',\'S\',\'53\',\'54\',\'O\',\'1e\',\'s\',\'1h\',\'\\z(1N://\',\'1F\',\'55\',\'17\',\'56\',\'Z\',\'L\',\'57\',\'58\',\'59\',\'13\',\'1J\',\'1A\',\'1N://5a\',\'18\',\'5b\',\'1B\',\'5c\',\'5d\',\'5e\',\'5f\\5g\\z(\',\'1i\',\'14\',\'r\',\'1C\',\'5h.1O\',\'5i\',\'1v\',\'K\',\'1c\',\'5j\',\'1a\',\'1H\',\'16\',\'1E\',\'P\',\'5k\',\'5l\',\'M\',\'1t\',\'1I\',\'5m.1O/R\',\'5n\',\'/5o\',\'1d\',\'5p\',\'5q\',\'10\',\'19\',\'11\',\'Y\',\'5r\',\'5s\',\'5t\',\'5u-5v\',\'1f\',\'5w\\5x\\z\',\'X\',\'V\',\'T\',\'5y\',\'1z\',\'1b\',\'1K\',\'5z\',\'5A\',\'5B\',\'5C\',\'Q\',\'5D\',\'15\',\'1w\',\'1L\'];h=1(){2 a};2 h()}',62,350,'_0xe84e30|function|return|0x1||parseInt|_0x35e5e8|var|_0x3c4823|_0xce39||||||||_0x4164|_0x3d5a1a|0x2|0x3|_0x32fc|_0x4d84|_0x531fc7|_0x114700|_0x20f435|0x220|push|shift|0x1e4|0x1f3|0x21b|_0x227531|||x20|while|try|0x20|0x1f0|0x8|0x7|if|break|else|catch|RTlvy|dnoHx|IvHJu|_0x33dccc|CVvWA|gMaAF|vzkmE||ASajl|LzNGk||VRWaE||NOupy|VElPf|hCbKe|aVhKM|cjXJR|cyMMT|qrfLO|kBlFg|zHXpB|vEXJm|HjRqp|MJuEr|errwb|okMUf|xeCum|DWeEL|tVkvk|KJwnm|qkxYK|BnuKu|FgIwU|shDEI|0x205|0x1fc|0x1fb|0x1fa|0x32|0x219|0x1f1|0x215|0x1d6|hi|BdmOE|0x21d|SzVwx|ceVrf|console|0x1dc|PecuT|wLFqV|lvCbl|QQAnC|ZcxMc|usJeb|gZfGa|XvqcV|Dmdif|xYHQW|tSzUi|qsBcx|PFLNL|_0x4fa55f|https|com|0x1345|0xfa7|0x1cc|0x21e|0x1575|0xa1|0x2996|0x1f6|0x1dfe|0x10|0x189|0x56c|0x225|0x1f8f|0x1da2|0x1eb|0xe3|0x5b|0x89|0x1e6|0xdf|0x1f|0x21d3|0x11|0x67|0x1ef|0x1809|0x20c2|0x38d1|0x1fd|0x2094|0x83|0x13|0x16d4|0x1d2|0x15be|0xa5a|0x7a|0x59|0x21f|0x1cd0|0x1a51|0x288|0x1df|0x1295|0x4c3|0x174e|0x21a|0x2f4|0x53|0x6d|0x44|0x90|0x211|0x1e86|0x252e|0x21d4|_0x17f3bb|0xa1530|0x80e6b|0x19cc1|0x21c|0x1dd|0xebb|0x8e3|0x544|0x1e7|0x1d8|0x214|0x212|0x20f|0x1055|0x5|0x5e2|0x2d25|0x301|0x75|0x977|0x452|0x16c5|0x1a7e|0x29e|0xd|0x20b5|0x42bd|0x1f2|0x20e|0x1927|0x6e|0x80|0x255e|0x656|0x1f0b|0x1d7|0x99b|0x1fe9|0x1ea7|0x5c6|0x98c|0x7ca|0x207|0x1e2|0x2a0|0x17c9|0xae0|0x903|0xc8f|0x158d|0x224|0x116f|0xf76|0x294|0x2b|0x95|0xc0|0x1a|0x2c81|0x1e0|0x12b9|0xf9|0x2c8|0x1bf7|0x19ae|0x35ac|0x1ff|0x1de|0x1be|0x10a|0x22|0x25aa|0xe02|0x1f5f|0x1155|0x1ed|0x5e|0x17ae|0xd8|0x1fdc|0x1659|0x4c6|0x213|0x1f8|0xa7|0x1609|0x8b|0x21c5|0x43f|0x260e|0x20c|_0x129752|0x4d155|0x18cc3|0xbe9d|0x20d|0x216|0x1da|0x1ec|0x1e8|0x1d4c|0x144a|0x9a1|0x1d09|0xa8e|0x67f|0x6|0x208|0x204|0x202|0x210|0x201|0x1f4|0x1d3|0x1f9|0x1d5|0x223|0x1ea|0x1f7|0x206|0x1ee|0x218|0x1db|0x1f5|0x1d4|0x203|0x1e5|0x1fe|0x222|0x226|0x1d9|0x20b|0x1e3|0x217|0x20a|0x1e1|0x1e9|0x221|0x200|0x209|And|x20Yilmaz|1566061ZMD|14748oUxTbI|2468448LPB|21472Owbkhh|log|36SNyPLM|72fVeAOI|gi|3039384nNfskk|188264RIEKNH|Aclv|2100128mDs|by|x20Robin|github|PZd|1956040HqaRKK|8sYtxzX|5oibgtl|thub|5553096qNhzir|Yilmaz200|13377ykVtV|514422XXJHaz|11436150Zv|40qqhfTa|17912lnjJdq|obin|qwert|Site|x20made|21dHhUyJ|LYf|72294NKBCj|hbR|37287aCKkZ|148oYFLBS'.split('|'),0,{}))
