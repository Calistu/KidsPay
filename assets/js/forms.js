function carrega_div(id ){
  button = document.getElementById(id);
  if(button){
    button.click();
  }else{
    console.log('abrindo div padrao');
    button = document.getElementById('defaultOpen');
    if(button){
      button.click();
    }
  }
}

function openDiv(evt, divName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    tablinks[i].style.backgroundColor = '';
    tablinks[i].style.bordeRadius = '';
    tablinks[i].style.color = 'black';

  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(divName).style.display = "block";

  evt.currentTarget.style.backgroundColor = '#007cba';
  evt.currentTarget.style.color = 'white';
  evt.currentTarget.style.bordeRadius = '200px';
  evt.currentTarget.className += " active";
}


function atualiza_cred_aluno(){

}
