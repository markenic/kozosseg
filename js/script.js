let places = [], places2 = [], people = [], resultPlaces = [], wantedPlaces = [-1,-1,-1],placeTypes=[];
const loadedPlace = (type) =>{
  $.ajax({
    url: 'assets/getDatas.php',
    type: 'POST',
    data:{
      wData:"places"
    },
    success: function(msg) {
      if(msg!="empty"){
        console.log(JSON.parse(msg));
        places = JSON.parse(msg);
        places2 = places;
        const map = new Map();
        for (const item of places) {
            if(!map.has(item.place)){
                if(item.type!=-1){
                  map.set(item.place, true);
                  resultPlaces.push(item.place);
                }

            }
        }
      }
      $.ajax({
        url: 'assets/getDatas.php',
        type: 'POST',
        data:{
          wData:"categories"
        },
        success: function(msg) {
          if(msg!="empty"){
            placeTypes = JSON.parse(msg);
          }
          if(type=="table"){
            loadPage();

          }else if(type=="getPlace"){
            getPlaces();
          }else if(type=="getAPlaces"){
            adminLoad();
            categories();
          }
        }  
      });  
    }             
  });
};

let option = [];


let table, td = [], tr = [], td2 = [], buttons = [];

const loadPage = () => {
  let placeCount = 0;
  places.forEach(element => {
    if(element.type!=-1) placeCount++;
  });
  $("#placeCount")[0].innerHTML=placeCount;
  table = document.createElement("table");
  $(".table")[0].appendChild(table);
  if(places2.length==0){
    console.log("asd");
    let text = document.createElement("h5");
    text.style.textAlign="center";
    text.style.margin="20px";
    text.setAttribute("class","text-info");
    text.innerHTML="Jelenleg egyetlen helyszín sincs, nézz vissza később!";
    $(".table")[0].appendChild(text);
    return;
  }
  for(let i = 0;i<placeTypes.length;i++){

    tr[i] = document.createElement("tr");
    td2[i] = document.createElement("td");
    td2[i].setAttribute("class","fullWidth text-info");
    td2[i].innerHTML="<h5>"+placeTypes[i].name+"</h5>";
    tr[i].appendChild(td2[i]);
    table.appendChild(tr[i]);
    for(let k = 0;k<places2.length;k++){
      if(places2[k].type==placeTypes[i].id){
        td[k]=document.createElement("button");
        td[k].innerHTML=places2[k].name+ " - "+places2[k].place;
        td2[i].appendChild(td[k]);
        td[k].id=k;
        td[k].setAttribute("class","btn btn-light bg-light tdBtn");
        td[k].onclick=function() {makeInfoBox(this)};
      }

    }
  }
  $.ajax({
    url: 'addplace.php',
    type: 'GET',
    data: {
      reqType:"getPlace"
    },
    success: function(msg) {
      console.log(msg);
      msg = JSON.parse(msg);
      if(msg.success){
        
        wantedPlaces = [parseInt(msg.response[0]),parseInt(msg.response[1]),parseInt(msg.response[2])];
        console.log(wantedPlaces);
      }else{
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
        console.log("%c"+msg.response,"color:red");
      }
    }
  });
};
const makeInfoBox = (that) =>{
  let box = document.createElement("div"),title = places[that.id].name,boxInside=document.createElement("div");
  let p = document.createElement("p");
  boxInside.appendChild(p);
  p.innerHTML="Tanár: <h6>"+places[that.id].teacher+"</h6>\nTevékenység: <h6>"+places[that.id].name+"</h6>\nHelyszín: <h6>"+places[that.id].place+"</h6>";
  box.appendChild(boxInside);
  alertify.confirm(title, box, function(){addPlace(that)}, function(){}).set('labels', {ok:'Tovább', cancel:'Mégse'}); ;

};

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

let checks = [];
const sortByPlaces = () =>{
  let box = document.createElement("div"),boxInside=document.createElement("div"),title = "Helyszínek";

  checks = [];
  let labels=[],spans=[];
  for(let i = 0; i<resultPlaces.length;i++){
    checks[i] = document.createElement("input");
    checks[i].setAttribute("class","check");
    checks[i].setAttribute("type", "checkbox");
    checks[i].setAttribute("id", resultPlaces[i]);  
    labels[i] = document.createElement("label");
    labels[i].setAttribute("class","cont");
    labels[i].innerHTML=resultPlaces[i]+" ";
    spans[i] = document.createElement("span");  
    spans[i].setAttribute("class","checkmark"); 

    boxInside.appendChild(labels[i]);
    labels[i].appendChild(checks[i]);
    labels[i].appendChild(spans[i]);
  }
  box.appendChild(boxInside);
  alertify.confirm(title, box, function(){sort("place")}, function(){}).set('labels', {ok:'Tovább', cancel:'Mégse'}); ;

};

const sort = (type) =>{
  if(type=="place"){
    $("table")[0].remove();
    places2 = [];
    for(let i = 0; i<places.length;i++){
      for(let k = 0;k<checks.length;k++){
        if(places[i].place==checks[k].id&&checks[k].checked){
          places2.push(places[i]);
        } 
      }
      
    }
    loadPage();
  }
};

const removeFilters = () => {
  $("table")[0].remove();
  places2 = places;
  loadPage();
};
let canSubscribe = false;
const addPlace = (that) => {
  console.log(wantedPlaces);
  if(wantedPlaces.includes(-1)==false){
    alertify.notify('Hiba! Max 3 helyszínt választhatsz.', 'error', 3);
    canSubscribe = false;
  }else{
    for(let i = 0;i<wantedPlaces.length;i++){
      if(wantedPlaces[i]==-1){
        if(wantedPlaces.includes(places[that.id].id)==false){
          wantedPlaces[i] = parseInt(places[that.id].id);
          canSubscribe = true;
          break;
        }else{
          alertify.notify('Hiba! Ez a helyszín már szerepel!', 'error', 3);
          canSubscribe = false;
          break;
        }
      }
    }
  }

  $.ajax({

      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData:"setUserPlaces",
        place: wantedPlaces
      },
      success: function(msg) {
        console.log(msg);
        msg = JSON.parse(msg);

        if(msg.success){
          if(canSubscribe){
            alertify.notify('Sikeres jelentkezés!', 'success', 3);
          }
          
        }else{
          if(msg.response=="Not logined user"){
            alertify.notify('Hiba! Nem vagy bejelentkezve!', 'error', 3);
          }else{
            alertify.notify('Hiba! Szólj egy fejlesztőnek!', 'error', 3);
            console.log("%c"+msg.response,"color:red");
          }

        }
      }         
  });
};
let placesFromServer = [];
let cards = [];

const getPlaces = () =>{
  $.ajax({
    url: 'addplace.php',
    type: 'GET',
    data: {
      reqType:"getPlace"
    },
    success: function(msg) {
      msg = JSON.parse(msg);
      console.log(msg);
      if(msg.success){
        for(let i = 0; i < msg.response.length;i++){
          if(msg.response[i]!=-1){
            cards[i]=makeCard(i," ","ownPlaces");
            cards[i].children[0].innerHTML=places.find(x => x.id == msg.response[i]).name+" - "+places.find(x => x.id == msg.response[i]).place;
          }else if(msg.response.every( v => v == -1 )){
            cards[0]=makeCard(null);
            cards[0].children[0].innerHTML="Nincs egyetlen választott helyszíned sem! :(";
            break;
          }
        }
      }
    }               
  });
};
const makeCard = (id,name,type) =>{
  let li = document.createElement("li");
  $(".cards")[0].appendChild(li);
  li.setAttribute("class","list-group-item d-flex justify-content-between");
  li.style.marginBottom="10px";
  li.style.borderLeft="2px solid #5BC0DE";
  let text = document.createElement("p");
  li.setAttribute("name",name);
  text.innerHTML = name;
  text.setAttribute("class","p-0 m-0 flex-grow-1");
  li.appendChild(text);
  if(id!=null){
    if(type!="ownPlaces"){
      let icon = document.createElement("a");

      icon.innerHTML='<i class="fas fa-edit fa-lg"></i>';
      icon.setAttribute("class","edit text-info float-right");
      icon.onclick=function(){editPlace(id)};
      li.appendChild(icon);
    
    }else{
      li.id="place"+(id+1);
    }
    
    icon = document.createElement("a");
    icon.innerHTML='<i class="fas fa-trash-alt fa-lg"></i>';
    icon.setAttribute("class","exit text-warning float-right");
    icon.onclick=function(){removePlace(id,name,li.id,type)};
    li.appendChild(icon);
    icon.style.marginLeft="10px";  

  }

  return li;
};

const removePlace = (id,name,liid,type) =>{
  alertify.confirm('Törlés','Biztosan törölni szeretnéd ezt a helyszínt?',
  function(){
    if(type=="ownPlaces"){
      $.ajax({
        url: 'assets/changeDatas.php',
        type: 'POST',
        data:{
          wData:"removePlace",
          name:name,
          liid:liid
          
        },
        success: function(msg) {
          console.log(msg);
          msg = JSON.parse(msg);
          if(msg.success){
            alertify.notify('Sikeres törlés!', 'success', 3);
            $("#"+liid).remove();
            if(!$("#place1")[0]&&!$("#place2")[0]&&!$("#place3")[0]){
              makeCard(null).children[0].innerHTML="Nincs egyetlen választott helyszíned sem! :(";
            }

          }else{
            alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
            console.log("%c"+msg.response,"color:red");
          }
          //loadUsers(msg);
        }               
      });
    }else if(type=="global"){
      $.ajax({
        url: 'assets/changeDatas.php',
        type: 'POST',
        data:{
          wData:"removeGlobalPlace",
          id:id
        },
        success: function(msg) {
          console.log(msg);
          msg = JSON.parse(msg);
          if(msg.success){
            alertify.notify('Sikeres törlés!', 'success', 3);
          }else{
            alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
            console.log("%c"+msg.response,"color:red");
          }


        }               
      });
    }
  },function(){});

}
let cardsPerPages = 10;

const adminLoad = () =>{
  $.ajax({
    url: 'assets/getPeople.php',
    type: 'POST',
    data:{
      session:true
    },
    success: function(msg) {
      msg = JSON.parse(msg);
      if(msg.success){
        people = msg.response;
        loadUsers(msg.response);
      }else{
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
        console.log("%c"+msg.response,"color:red");
      }
    }               
  });

  if(places.length==0){
    let card = makeCard(null);
    card.children[0].innerHTML="Jelenleg nincs egyetlen helyszín sem:(";
    return;
  }

  for (let i = 0; i < places.length; i++) {
    cards[i]=makeCard(places[i].id,places[i].name+" - "+places[i].place,"global");
    cards[i].id=places[i].id; 
  }
};

const usersCards = (msg) =>{
  //console.log(msg.id);
  let card = document.createElement("div");
  let header = document.createElement("div");
  let text = document.createElement("h2");
  let button = document.createElement("button");
  let collapse = document.createElement("div");
  let collapseBody = document.createElement("div");
  card.setAttribute("class","card");
  card.setAttribute("name",msg.name);
  header.setAttribute("class","card-header");
  header.id="heading"+msg.id;
  card.style.marginBottom="10px";
  card.style.borderLeft="2px solid #5BC0DE";

  text.setAttribute("class","mb-0");

  button.setAttribute("type","button");
  button.setAttribute("class","btn btn-link collapsed");
  button.setAttribute("data-toggle","collapse");
  button.setAttribute("data-target","#collapse"+msg.id);
  button.setAttribute("aria-expanded","false");
  button.setAttribute("aria-controls","#collapse"+msg.id);
  if(msg.isAdmin==1){
    button.style.color="red";
  }
  button.innerHTML=msg.name;

  collapse.setAttribute("class","collapse");
  collapse.setAttribute("aria-labelledby","heading"+msg.id);
  collapse.setAttribute("data-parent","#asd");
  collapse.id="collapse"+msg.id;

  collapseBody.setAttribute("class","card-body"); 

  collapseBody.innerHTML = "<b>Admin</b>";
  let select = document.createElement("select");
  select.setAttribute("userID",msg.id);

  select.setAttribute("class","form-control selectt");
  select.setAttribute("onchange","setAdmin(this)");

  let c = document.createElement("option");
  let c2 = document.createElement("option");
  c.text="Nem";
  c2.text="Igen";
  c.value="nem";
  c2.value="igen";
  select.options.add(c);
  select.options.add(c2);
  select.selectedIndex = msg.isAdmin;

  collapseBody.appendChild(select);
  if(msg.isAdmin==0){
    c.setAttribute("selected",true);
  }else{
    c2.setAttribute("selected",true);
  }

  collapseBody.innerHTML += "<br><b>Helyszínek</b><br>";

  choosed = [msg.place1,msg.place2,msg.place3];

  for(let i = 0; i < choosed.length;i++){
    if(choosed[i]!=-1&&places.find(x => x.id == choosed[i])){//places.find(x => x.id == id)
      collapseBody.innerHTML += places.find(x => x.id == choosed[i]).place+" - "+ places.find(x => x.id == choosed[i]).name +"<br>";
    }else if(choosed.every( v => v == -1 )||!places.find(x => x.id == choosed[i])){
      collapseBody.innerHTML +="Nincs egyetlen választott helyszíne sem! :(";
      break;
    }
  }

  collapseBody.innerHTML += "<br><b>Email</b><br>"+msg.email;

  text.appendChild(button);
  header.appendChild(text);
  card.appendChild(header);
  card.appendChild(collapse);
  collapse.appendChild(collapseBody);


  $(".userCards")[0].appendChild(card);
  return card;
};

const setAdmin = (that) => {
  $.ajax({
    url: 'assets/setAdmin.php',
    type: 'POST',
    data: {
      id:that.getAttribute("userID"),
      value:(that.value=="igen"?1:0)
    },
    success: function(msg) {
      msg = JSON.parse(msg);
      if(msg.success==true){
        alertify.notify('Sikeres módosítás!', 'success', 3);
      }else{
        if(msg.response=="notAdmin"){
          alertify.notify('Hiba! Nem vagy admin.', 'error', 3);
        }else{
          alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
          console.log("%c"+msg.response,"color:red");
        }
        
      }
    }               
  });
};
let loadedUserCard = [];
const loadUsers = (msg) =>{
  for (let i = 0; i < msg.length; i++) {
    loadedUserCard[i] = usersCards(msg[i]);
  }

};

const editPlace = id => {
  let obj = places.find(x => x.id == id);
  let box = document.createElement("div"),title = "Szerkesztés",boxInside = document.createElement("div");
  let p = document.createElement("p");

  boxInside.appendChild(p);
  p.innerHTML="Tanár: <input type='text' class='form-control teacher' value='"+obj.teacher+"'></input>\n"+
  "Tevékenység: <input type='text' class='form-control name' value='"+obj.name+"'></input>\n"+
  "Helyszín: <input type='text' class='form-control place' value='"+obj.place+"'></input>\nTípus:";
  let select = document.createElement("select");
  select.setAttribute("class","form-control typeSelect");

  let c2 = document.createElement("option");
  c2.text="Nincs kategória";
  c2.id=-1;
  select.options.add(c2); 
  let c;
  for(let i = 0;i<placeTypes.length;i++){
    c = document.createElement("option");
    c.text=placeTypes[i].name;
    c.id=placeTypes[i].id;
    select.options.add(c);
    if(c.id==obj.type){
      c.style.color="red";
      c.selected=true;
    }else if(c2.id==obj.type){
      c2.style.color="red";
      c.selected=true;
    }

  }
  console.log(select);

  boxInside.appendChild(select);
  box.appendChild(boxInside);

  alertify.confirm(title, box, function(){sendRefreshedData(id)}, function(){}).set('labels', {ok:'Tovább', cancel:'Mégse'});
};

const sendRefreshedData = id =>{
  console.log($(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id);
  console.log((placeTypes.find(x => x.id == $(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id)));
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData:"editPlace",
      id:id,
      place:$(".place")[0].value,
      teacher:$(".teacher")[0].value,
      type:$(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id,
      name:$(".name")[0].value
    },
    success: function(msg) {
      msg = JSON.parse(msg);
      console.log(msg);
      if(msg.success){
        alertify.notify('Sikeres módosítás', 'success', 3);
      }else{
        alertify.notify('Hiba! Keress fel egy fejleszőt!', 'error', 3);
        console.log("%c"+msg.response,"color:red");
      }
    }               
  });
};

const newPlace = () => {
  let box = document.createElement("div"),title = "Új helyszín",boxInside = document.createElement("div");

  let p = document.createElement("p");

  boxInside.appendChild(p);
  p.innerHTML="Tanár: <input type='text' class='form-control teacher' required placeholder='Tanár neve'></input>\n"+
  "Tevékenység: <input type='text' class='form-control name' required placeholder='Tevékenység'></input>\n"+
  "Helyszín: <input type='text' class='form-control place' required placeholder='Helyszín'></input>";
  let select = document.createElement("select");
  select.setAttribute("class","form-control typeSelect");
  let c;
  c = document.createElement("option");
  c.text="Nincs kategória";
  c.id=-1;
  select.options.add(c);
  for(let i = 0;i<placeTypes.length;i++){
    c = document.createElement("option");
    c.text=placeTypes[i].name;
    c.id=placeTypes[i].id;
    select.options.add(c);
  }

  boxInside.appendChild(select);
  box.appendChild(boxInside);
  alertify.confirm(title, box, function(){sendNewDataToServer()}, function(){}).set('labels', {ok:'Tovább', cancel:'Mégse'});
};

const sendNewDataToServer = id =>{
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData:"newPlace",
      place:$(".place")[0].value,
      teacher:$(".teacher")[0].value,
      type:$(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id,
      name:$(".name")[0].value
    },
    success: function(msg) {
      msg = JSON.parse(msg);

      if(msg.success==true){
        alertify.notify('Sikeres módosítás!', 'success', 3);
      }else{
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
        console.log("%c"+msg.response,"color:red");
      }
    }               
  }); 
};

const categories = () =>{
  let p = document.createElement("p");
  for (let i = 0; i < placeTypes.length; i++) {
    $(".categories")[0].appendChild(makeCategoriesCard(placeTypes[i].id,placeTypes[i].name));
  }
};
const makeCategoriesCard = (id,name) =>{
  let li = document.createElement("li");
  $(".cards")[0].appendChild(li);
  li.setAttribute("class","list-group-item d-flex justify-content-between");
  li.style.marginBottom="10px";
  li.style.borderLeft="2px solid #5BC0DE";
  let text = document.createElement("p");
  text.innerHTML = name;
  text.setAttribute("class","p-0 m-0 flex-grow-1");
  li.appendChild(text);
  if(id!=null){
    if(name!="ownPlaces"){
      let icon = document.createElement("a");
      icon.innerHTML='<i class="fas fa-edit fa-lg"></i>';
      icon.setAttribute("class","edit text-info float-right");
      icon.onclick=function(){editPlace(id)};
      li.appendChild(icon);
    }else{
      li.id="place"+(id+1);
    }
    
    icon = document.createElement("a");
    icon.innerHTML='<i class="fas fa-trash-alt fa-lg"></i>';
    icon.setAttribute("class","exit text-warning float-right");
    icon.onclick=function(){removePlace(id,name,li.id)};
    li.appendChild(icon);
    icon.style.marginLeft="10px";  
  }
  return li;
};

const searchPersonByName = () =>{
  let text = $("#searchname")[0].value.toUpperCase();
  for(let i = 0; i < loadedUserCard.length; i++){
    if (loadedUserCard[i].getAttribute("name").toUpperCase().indexOf(text) > -1) {
      loadedUserCard[i].style.display = "";
    } else {
      loadedUserCard[i].style.display = "none";
    }
  }
};

const searchPlaceByName = () =>{
  let text = $("#searchPlace")[0].value.toUpperCase();
  for(let i = 0; i < cards.length; i++){
    if (cards[i].getAttribute("name").toUpperCase().indexOf(text) > -1) {
      cards[i].style.display = "";
    } else {
      cards[i].setAttribute('style', 'display: none !important');

    }
  }
};