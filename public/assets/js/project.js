/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
  $('.dropbtn').on('click', function(){
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
  })

  $('.noty').on('click', function(){
      var dropdowns = document.getElementsById("notifications");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
  })

function toggle_dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}
function open_notificacions() {
    document.getElementById("notifications").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

   
  }
}

function get_cookie(cookiename) 
{
  // Get name followed by anything except a semicolon
  var cookiestring=RegExp(""+cookiename+"[^;]+").exec(document.cookie);
  // Return everything after the equal sign, or an empty string if the cookie name not found
  return decodeURIComponent(!!cookiestring ? cookiestring.toString().replace(/^[^=]+./,"") : "");
}

function set_cookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
//check the passed array for time formatting hh:mm/00H:00min/00Horas:00m/
function logArrayElements(element, index, array) {
  let match = element.toString().match(/^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$/g);
  let n1=0;
  let n2 = 0;
  if(match){
    if(n1 = match[0].match(/\d+/g)[0]){
      if(n2 = match[0].match(/\d+/g)[1]){
        array[index] = (n1+'.'+n2)*1;
      }else{
        array[index] = n1*1;
      }
    }
  }else{
    array[index] = element*1;
  }
}

function logchekElements(element) {
  let match = element.toString().match(/^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$/g);
  let n1=0;
  let n2 = 0;
  if(match){
    if(n1 = match[0].match(/\d+/g)[0]){
      if(n2 = match[0].match(/\d+/g)[1]){
        return (n1+'.'+n2)*1;
      }else{
        return n1*1;
      }
    }
  }else{
    return element*1;
  }
}

function htmlEntityChecker(check) {
  //agt mayor que alt menor que
    var characterArray = ['≥', '≤', '&lt;', '&gt;']
    var sol = -1;
    $.each(characterArray, function(idx, ent) {
        if (check.indexOf(ent) != -1) {
          sol = idx;
          return true;
        }
    });
    return sol;
}