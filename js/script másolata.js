

function adminLogin(){
    


}


var places = [];
$(document).ready(function(){
  $.getJSON("assets/datas/datas.json", function(result){
    $.each(result, function(i, field){
      places[i]=field;
    });
    loadPage();
    //loadList();
  });
  
});




function decision(){

    $(".signup").css("visibility", "visible");
    $(".login").fadeOut("slow");

    $(".signup").fadeIn("slow");

}

var placeTypes = ["Szociális és jótékonyság terület","Kulturális és közösségi terület",
"Környezet- és természetvédelem","Katasztrófavédelem",
"Óvodás korú, sajátos nevelési igényű gyermekekkel, közös sport- és szabadidős területen folytatható tevékenység",
"Bűn és balesetmegelőzés"];


var option = [];



let table = $(".table")[0];
let td = [];
let tr = [];
let td2 = [];
let buttons = [];

const loadPage = () => {
  for(let i = 0;i<placeTypes.length;i++){
    
    buttons[i] = document.createElement("button");
    buttons[i].setAttribute("class","btn btn-danger text-uppercase");
    buttons[i].innerHTML+=placeTypes[i];
    $(".categories")[0].appendChild(buttons[i]);

    tr[i] = document.createElement("tr");
    td2[i] = document.createElement("td");
    td2[i].setAttribute("class","fullWidth");
    td2[i].innerHTML="<h6>"+placeTypes[i]+"</h6>";
    tr[i].appendChild(td2[i]);
    table.appendChild(tr[i]);

    for(let k = 0;k<places.length;k++){
      if(places[k].type==i){
        td[k]=document.createElement("td");
        td[k].innerHTML=places[k].name+ " - "+places[k].place;
        td2[i].appendChild(td[k]);

        td[k].id=k;
        td[k].onclick=function() {makeBox(this)};
      }
      
    }
  }
};
const makeBox = (that) =>{
  $(".box")[0].style.display="block";
  $(".title")[0].innerHTML=places[that.id].name;
  $(".teacher")[0].innerHTML="Tanár: <h6>"+places[that.id].teacher+"</h6>";
  $(".description")[0].innerHTML="Típus: <h6>"+placeTypes[places[that.id].type]+"</h6>";
  $(".activity")[0].innerHTML="Tevékenység: <h6>"+places[that.id].activity+"</h6>";
  $(".place")[0].innerHTML="Helyszín: <h6>"+places[that.id].place+"</h6>";
};
window.onclick = function(event) {
  if (event.target == $(".box")[0]) {
    $(".box")[0].style.display = "none";
  }
}
let li = [];
let icons;
const loadList = () => {
  for(let i = 0;i<places.length;i++){
    li[i] = document.createElement("li");
    li[i].setAttribute("class","list-group-item d-flex justify-content-between");
    li[i].innerHTML=places[i].name+ " - "+places[i].place;
    icons = document.createElement("span");
    icons.innerHTML='<i class="fas fa-times"></i>';
    icons.setAttribute("class","exit");
    li[i].appendChild(icons);
    $(".list")[0].appendChild(li[i]);
  }
};