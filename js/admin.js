//////////////////////////////
Element.prototype.setAttributes = function (attrs) {
  for (var idx in attrs) {
    if ((idx === 'styles' || idx === 'style') && typeof attrs[idx] === 'object') {
      for (var prop in attrs[idx]) {
        this.style[prop] = attrs[idx][prop];
      }
    } else if (idx === 'html') {
      this.innerHTML = attrs[idx];
    } else {
      this.setAttribute(idx, attrs[idx]);
    }
  }
};

const context = new window.AudioContext();

function playFile(filepath) {
  // see https://jakearchibald.com/2016/sounds-fun/
  // Fetch the file
  fetch(filepath)
    // Read it into memory as an arrayBuffer
    .then(response => response.arrayBuffer())
    // Turn it from mp3/aac/whatever into raw audio data
    .then(arrayBuffer => context.decodeAudioData(arrayBuffer))
    .then(audioBuffer => {
      // Now we're ready to play!
      const soundSource = context.createBufferSource();
      soundSource.buffer = audioBuffer;
      soundSource.connect(context.destination);
      soundSource.start();
    });
}
//////////////////////////////


let places = [],
  teachers = [],
  people = [],
  userPlaces = [],
  placeTypes = [],
  classes = [],
  loadedUserCard = [];

let loaded = 0,
  successLoad = false;
let loadEveryThing = () => {


  $.ajax({ //Places
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "places"
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        places = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });

  $.ajax({ //Teachers
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "teachers"
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        teachers = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });

  $.ajax({ //People
    url: 'assets/getPeople.php',
    type: 'POST',
    data: {
      wData: "allPeople",
      session: true
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        people = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });

  $.ajax({ //User Places
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "getPlaces",
      session: true
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        userPlaces = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });

  $.ajax({ //placeTypes
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "categories"
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        placeTypes = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });
  
  $.ajax({ //Classes
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "classes"
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        classes = msg.response;
        loaded += 1; 
      } else {
        if (msg.response) {
          console.log("Error: " + msg.response);
        } else {
          console.log("Error: Szólj egy fejlesztőnek!");
        }
      }
    },
    error: function (textStatus, err) {
      if (err == "error") {
        alertify.notify('Hiba! A részletekért nézd meg a konzolt!', 'error', 5);
        console.log("%c" + err, "color:red");
      }
    }
  });
  
  let int = setInterval(function(){checkFor(int)}, 1000);
  let timeOut = setTimeout(function(){
    if(successLoad == false){
      $(".loader-wrapper").fadeOut("slow");
      $("header").css("display","flex");
      buildSite();
      successLoad = true;
      clearInterval(int);
      alertify.notify('Elképzelhető, hogy valamilyen adatot nem lehetett betölteni. Ha hibát tapasztalsz, próbáld meg frissíteni az oldalt!', 'error', 12);     
    }
  },1000*5);

};

loadEveryThing();

const checkFor = (that) =>{
  if(loaded == 6){
    clearInterval(that);
    $(".loader-wrapper").fadeOut("slow");
    $("header").css("display","flex");
    buildSite();
    successLoad = true;
  }
};

const buildSite = () =>{

  //First of all, put the places
  if (places.length == 0) {
    makeCard(null, "noPlace").children[0].innerHTML = "Jelenleg nincs egyetlen helyszín sem <i class='fas fa-sad-tear fa-lg'></i>";
  }

  for (let i = 0; i < places.length; i++) {
    makeCard(places[i].id, places[i].name + " - " + places[i].place, "global").id = "place" + places[i].id;
  }

  //Categories
  if (placeTypes.length == 0) {
    makeCategoriesCard(null, "noCat").children[0].innerHTML = "Jelenleg nincs egyetlen kategória sem <i class='fas fa-sad-tear fa-lg'></i>";
    return;
  }
  for (let i = 0; i < placeTypes.length; i++) {
    $(".categories")[0].appendChild(makeCategoriesCard(placeTypes[i].id, placeTypes[i].name));
  }

  //People
  for (let i = 0; i < people.length; i++) {
    loadedUserCard[i] = usersCards(people[i],userPlaces);
  }

  //Classes
  for (let i = 0; i < classes.length; i++) {
    if(typeof(classes[i])!="undefined"){
      makeClassedCard(classes[i].id,classes[i].className);
    }
  }
  getClasses("classSelectToSort");
};

const makeCard = (id, name, type) => {
  let li = document.createElement("li");
  $(".cards")[0].appendChild(li);
  li.setAttribute("class", "list-group-item d-flex justify-content-between placeCard shadow-sm text-muted");
  li.style.marginBottom = "10px";
  li.style.borderLeft = "2px solid #5BC0DE";
  let text = document.createElement("p");
  li.setAttribute("name", name);
  text.innerHTML = name;
  text.setAttribute("class", "p-0 m-0 flex-grow-1");
  li.appendChild(text);
  if (id != null) {
    if (type != "ownPlaces") {
      let icon = document.createElement("a");
      icon.innerHTML = '<i class="fas fa-edit fa-lg"></i>';
      icon.setAttribute("class", "edit text-main-dark float-right");
      icon.onclick = function () {
        editPlace(id)
      };
      li.appendChild(icon);

    } else {
      li.id = id;
      let icon = document.createElement("a");
      icon.innerHTML = '<i class="fas fa-edit fa-lg"></i>';
      icon.setAttribute("class", "edit text-main-dark float-right");
      icon.onclick = function () {
        editHour(id);
      };
      li.appendChild(icon);
    }
    icon = document.createElement("a");
    icon.innerHTML = '<i class="fas fa-trash-alt fa-lg"></i>';
    icon.setAttribute("class", "exit text-warning float-right");
    icon.onclick = function () {
      removePlace(id, li.id, type)
    };
    li.appendChild(icon);
    icon.style.marginLeft = "10px";
  }
  return li;
};

const makeCategoriesCard = (id, name) => {
  let li = document.createElement("li");
  $(".categories")[0].appendChild(li);
  li.setAttribute("class", "list-group-item d-flex justify-content-between categoryCard shadow-sm");
  let text = document.createElement("p");
  li.setAttribute("name", name);
  text.innerHTML = name;
  text.setAttribute("class", "p-0 m-0 flex-grow-1");
  li.appendChild(text);
  if (id != null) {
    let icon = document.createElement("a");
    icon.innerHTML = '<i class="fas fa-edit fa-lg"></i>';
    icon.setAttribute("class", "edit text-main-dark float-right");
    icon.onclick = function () {
      editCategory(id)
    };
    li.appendChild(icon);
    li.id = "cat" + id;
    icon = document.createElement("a");
    icon.innerHTML = '<i class="fas fa-trash-alt fa-lg"></i>';
    icon.setAttribute("class", "exit text-warning float-right");
    icon.onclick = function () {
      removeCategory(id, li.id);
    };
    li.appendChild(icon);
    icon.style.marginLeft = "10px";
  }
  return li;
};

const usersCards = (msg,place) => {
  let card = document.createElement("div");
  let header = document.createElement("div");
  let text = document.createElement("h2");
  let button = document.createElement("button");
  let collapse = document.createElement("div");
  let collapseBody = document.createElement("div");
  header.setAttribute("class", "card-header");
  header.id = "heading" + msg.id;
  let userPlaces = [];
  console.log(place);
  for(let i=0;i<place.length;i++){
    if(place[i].uid==msg.id){
      userPlaces.push(place);
    }
  }
  card.setAttributes({
    'class': 'card card'+msg.id,
    'name': msg.name,
    'uclass':msg.class,
    'styles': {
      'marginBottom': '10px',
      'borderLeft': '2px solid #5BC0DE'
    }
  });

  button.setAttributes({
    'id': 'user' + msg.id,
    'class': 'btn btn-link collapsed',
    'type': 'button',
    'data-toggle': 'collapse',
    'data-target': '#collapse' + msg.id,
    'aria-expanded': 'false',
    'aria-controls': '#collapse' + msg.id,
  });

  button.innerHTML = msg.name;
  if (msg.isAdmin == 1) {
    button.style.color = "#f71919";
  }

  collapse.setAttributes({
    'class': 'collapse',
    'aria-labelledby': 'heading' + msg.id,
    'id': 'collapse' + msg.id
  });

  collapseBody.setAttribute("class", "card-body");
  collapseBody.innerHTML += "<b>Felhasználó adatai</b><br>";
  collapseBody.innerHTML+="<button onclick='editUserDatas("+msg.id+")' class='btn btn-primary mb-3 mr-1'><i class='fas fa-edit'></i> Szerkesztés</button> <button onclick='removeUser("+msg.id+")' class='btn btn-danger mb-3'><i class='fas fa-trash-alt'></i> Törlés</button>";
  collapseBody.innerHTML += "<br><b>Admin</b>";
  let select = document.createElement("select");

  select.setAttributes({
    'userID': msg.id,
    'onchange': 'setAdmin(this)',
    'class': 'form-control select'
  });

  let c = document.createElement("option");
  let c2 = document.createElement("option");
  c.text = "Nem";
  c2.text = "Igen";
  c.value = "nem";
  c2.value = "igen";
  select.options.add(c);
  select.options.add(c2);
  select.selectedIndex = msg.isAdmin;

  collapseBody.appendChild(select);
  if (msg.isAdmin == 0) {
    c.setAttribute("selected", true);
  } else {
    c2.setAttribute("selected", true);
  }

  collapseBody.innerHTML += "<br><b>Helyszínek</b><br>";
  for (let i = 0; i < place.length; i++) {
    if(place[i].uid==msg.id){
      if(typeof(places.find(x => x.id == place[i].placeid))!="undefined"){
        collapseBody.innerHTML += places.find(x => x.id == place[i].placeid).place + " - " + places.find(x => x.id == place[i].placeid).name + " - " + place[i].hour + " órában" + "<br>";
      }else{
        collapseBody.innerHTML+="Hiba az adat betöltése közben!<br>";
      }
    }
  }
  if (userPlaces.length == 0) {
    collapseBody.innerHTML += "Nincs egyetlen választott helyszíne sem! <i class='fas fa-sad-tear fa-lg'></i><br>";
  } else {
    collapseBody.innerHTML += "<br>" +
      "<form action='lap.php' method='post'>" +
      "<input type='hidden' name='userid' value='" + msg.id + "'>" +
      "<button class='btn btn-primary paperbtn'><i class='fas fa-print'></i> Nyomtatási nézet</button>" +
      "</form>" +
      "<br>";
  }

  collapseBody.innerHTML += "<br><b>Email</b><br>" + msg.email;
  collapseBody.innerHTML += "<br><br><b>Osztály</b><br>";

  $.ajax({
    url: 'assets/getDatas.php',
    type: 'POST',
    data: {
      wData: "classes"
    },
    success: function (msg2) {
      msg2 = JSON.parse(msg2);
      if (msg2.success) {
        for (let i = 0; i < msg2.response.length; i++) {
          if (msg2.response[i].id == msg.class) {
            collapseBody.innerHTML += msg2.response[i].className;
            break;
          }  
        }
      }
    }
  });
  text.appendChild(button);
  header.appendChild(text);
  card.appendChild(header);
  card.appendChild(collapse);
  collapse.appendChild(collapseBody);


  $(".userCards")[0].appendChild(card);
  return card;
};

const makeClassedCard = (id, name) => {
  let li = document.createElement("li");
  $(".classesCard")[0].appendChild(li);
  li.setAttribute("class", "list-group-item d-flex justify-content-between classCard mb-1 shadow-sm");
  let text = document.createElement("p");


  li.setAttribute("name", name);
  text.innerHTML = name;
  text.setAttribute("class", "p-0 m-0 flex-grow-1");
  li.appendChild(text);
  if (id != null) {
    let icon = document.createElement("a");
    icon.innerHTML = '<i class="fas fa-edit fa-lg"></i>';
    icon.setAttribute("class", "edit text-main-dark float-right");
    icon.onclick = function () {
      editClass(id)
    };
    li.appendChild(icon);
    li.id = "class" + id;
    icon = document.createElement("a");
    icon.innerHTML = '<i class="fas fa-trash-alt fa-lg"></i>';
    icon.setAttribute("class", "exit text-warning float-right");
    icon.onclick = function () {
      removeClass(id, li.id);
    };
    li.appendChild(icon);
    icon.style.marginLeft = "10px";
  }
  return li;
};


//Lets make the user functions

//Add a new place
const newPlace = () => {
  let box = document.createElement("div"),
    title = "Új helyszín",
    boxInside = document.createElement("div");

  let p = document.createElement("p");

  let tlist = document.createElement("datalist");
  tlist.id="teacherlist";

  $.ajax({
    url:'assets/getDatas.php',
    type:'POST',
    data: {
      wData:'teachers'
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if(msg.success){
        for (let i = 0; i < msg.response.length; i++) {
          let teacher = msg.response[i];
          let to = document.createElement("option");
          to.setAttribute("value",teacher.name);
          tlist.appendChild(to);
          
        }
      }
    }
  });


  boxInside.appendChild(tlist);
  boxInside.appendChild(p);
  p.innerHTML = "Tanár: <input type='text' list='teacherlist' placeholder='Tanár' class='form-control teacher' required placeholder='Tanár neve'></input>\n" +
    "Tevékenység: <input type='text' placeholder='Tevékenység' class='form-control name' required placeholder='Tevékenység'></input>\n" +
    "Helyszín: <input type='text' placeholder='Helyszín' class='form-control place' required placeholder='Helyszín'></input>\nKategória:";
  let select = document.createElement("select");
  select.setAttribute("class", "form-control typeSelect");
  c = null;
  c = document.createElement("option");
  c.text = "Nincs kategória";
  c.id = -1;
  select.options.add(c);
  for (let i = 0; i < placeTypes.length; i++) {
    c = document.createElement("option");
    c.text = placeTypes[i].name;
    c.id = placeTypes[i].id;
    select.options.add(c);
  }

  boxInside.appendChild(select);
  box.appendChild(boxInside);
  alertify.confirm(title, box, function () {
    sendNewPlaceToServer()
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });

};

//Send the new place
const sendNewPlaceToServer = () => {
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData: "newPlace",
      place: $(".place")[0].value,
      teacher: $(".teacher")[0].value,
      type: $(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id,
      name: $(".name")[0].value
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        alertify.notify('Sikeres módosítás!', 'success', 5);

        let newplace = {
          id: parseInt(msg.response),
          place: $(".place")[0].value,
          teacher: $(".teacher")[0].value,
          type: $(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id,
          name: $(".name")[0].value
        };
        places.push(newplace);
        makeCard(places[places.length - 1].id, places[places.length - 1].name + " - " + places[places.length - 1].place, "global").id = "place" + places[places.length - 1].id;
        if (places.length != 0 && document.getElementsByName("noPlace")[0]) document.getElementsByName("noPlace")[0].remove();
      } else {
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
        console.log("%c" + msg.response, "color:red");
      }
    }
  });
};


//Edit a place
const editPlace = id => {
  let obj = places.find(x => x.id == id);
  let box = document.createElement("div"),
    title = "Szerkesztés",
    boxInside = document.createElement("div");
  let p = document.createElement("p");

  let tlist = document.createElement("datalist");
  tlist.id="teacherEditList";

  $.ajax({
    url:'assets/getDatas.php',
    type:'POST',
    data: {
      wData:'teachers'
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if(msg.success){
        for (let i = 0; i < msg.response.length; i++) {
          let teacher = msg.response[i];
          let to = document.createElement("option");
          to.setAttribute("value",teacher.name);
          tlist.appendChild(to);
          
        }
      }
    }
  });

  boxInside.appendChild(tlist);
  boxInside.appendChild(p);
  if(typeof(obj)!="undefined"){
    p.innerHTML = "Tanár: <input type='text' list='teacherEditList' placeholder='Tanár' class='form-control teacher' required value='" + teachers.find(x => x.id == obj.teacher).name + "'></input>\n" +
      "Tevékenység: <input type='text' placeholder='Tevékenység' class='form-control name' required value='" + obj.name + "'></input>\n" +
      "Helyszín: <input type='text' placeholder='Helyszín' class='form-control place' required value='" + obj.place + "'></input>\nTípus:";
    let select = document.createElement("select");
    select.setAttribute("class", "form-control typeSelect");

    let c2 = document.createElement("option");
    c2.text = "Nincs kategória";
    c2.id = -1;
    select.options.add(c2);
    let c;
    for (let i = 0; i < placeTypes.length; i++) {
      c = document.createElement("option");
      c.text = placeTypes[i].name;
      c.id = placeTypes[i].id;
      select.options.add(c);
      if (c.id == obj.type) {
        c.setAttribute("class", "text-main-dark");
        c.selected = true;
      } else if (c2.id == obj.type) {
        c2.setAttribute("class", "text-main-dark");
        c2.selected = true;
      }
    }
    boxInside.appendChild(select);
    box.appendChild(boxInside);
  }

  alertify.confirm(title, box, function () {
    if(typeof(obj)!="undefined"){
      sendRefreshedData("place", id)
    }
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });
};

//Edited place data
const sendRefreshedData = (type, id) => {
  if (type == "place") {
    $.ajax({
      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData: "editPlace",
        id: id,
        place: $(".place")[0].value,
        teacher: $(".teacher")[0].value,
        type: $(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id,
        name: $(".name")[0].value
      },
      success: function (msg) {
        let obj = places.find(x => x.id == id);
        console.log(msg);
        msg = JSON.parse(msg);
        if (msg.success) {

          alertify.notify('Sikeres módosítás', 'success', 5);
          playFile('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/success.mp3');

          obj.place = $(".place")[0].value;
          obj.name = $(".name")[0].value;
          obj.teacher = $(".teacher")[0].value;
          obj.type = $(".typeSelect")[0][$(".typeSelect")[0].selectedIndex].id;
          $("#place" + id)[0].children[0].innerHTML = places.find(x => x.id == id).name + " - " + places.find(x => x.id == id).place;
        } else {
          alertify.notify('Hiba! Keress fel egy fejleszőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  } else if (type == "category") {
    $.ajax({
      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData: "editCategory",
        id: id,
        name: $(".catName")[0].value
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres módosítás', 'success', 5);
          playFile('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/success.mp3');

          $("#cat" + id)[0].children[0].innerHTML = $(".catName")[0].value;
          placeTypes.find(x => x.id == id).name = $(".catName")[0].value;
        } else {
          alertify.notify('Hiba! Keress fel egy fejleszőt!', 'error',5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  }else if(type=="class"){
    $.ajax({
      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData: "editClass",
        id: id,
        name: $(".className")[0].value
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres módosítás', 'success', 5);
          playFile('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/success.mp3');

          $("#class" + id)[0].children[0].innerHTML = $(".className")[0].value;
          classes.find(x => x.id == id).className = $(".className")[0].value;
        } else {
          alertify.notify('Hiba! Keress fel egy fejleszőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  }else if(type=="user"){
    $.ajax({
      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData: "editUser",
        id: id,
        name: $(".userName")[0].value,
        email:$(".userEmail")[0].value,
        class:$(".editUserClass")[0][$(".editUserClass")[0].selectedIndex].value
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres módosítás', 'success', 5);
          playFile('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/success.mp3');
          console.log(msg);
          people.find(x => x.id == id).class = $(".editUserClass")[0][$(".editUserClass")[0].selectedIndex].value;
          //$("#class" + id)[0].children[0].innerHTML = $(".className")[0].value;
          //classes.find(x => x.id == id).className = $(".className")[0].value;
        } else {
          alertify.notify('Hiba! Keress fel egy fejleszőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  }

};

 //Remove a place from database
 const removePlace = (id, liid, type) => {
  alertify.confirm('Törlés', 'Biztosan törölni szeretnéd ezt a helyszínt?',
    function () {
      if (type == "ownPlaces") {
        $.ajax({
          url: 'assets/changeDatas.php',
          type: 'POST',
          data: {
            wData: "removePlace",
            id: id

          },
          success: function (msg) {
            msg = JSON.parse(msg);
            if (msg.success) {
              alertify.notify('Sikeres törlés!', 'success',5);

              $(document.getElementById(liid)).remove();
              if ($('.cards').is(':empty')) {
                makeCard(null, "noPlace").children[0].innerText = "Nincs egyetlen választott helyszíned sem! <i class='fas fa-sad-tear fa-lg'></i>";
                $(".paperbtn")[0].disabled = true;
              }

            } else {
              alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
              console.log("%c" + msg.response, "color:red");
            }
            //loadUsers(msg);
          }
        });
      } else if (type == "global") {
        $.ajax({
          url: 'assets/changeDatas.php',
          type: 'POST',
          data: {
            wData: "removeGlobalPlace",
            id: id
          },
          success: function (msg) {
            msg = JSON.parse(msg);
            if (msg.success) {
              alertify.notify('Sikeres törlés!', 'success', 5);
              $("#place" + id).remove();
              places.splice(places.findIndex(x => x.id == id), 1);
              if (places.length == 0) {
                makeCard(null, "noPlace").children[0].innerText = "Jelenleg nincs egyetlen helyszín sem <i class='fas fa-sad-tear fa-lg'></i>";
              }
            } else {
              alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
              console.log("%c" + msg.response, "color:red");
            }
          }
        });
      }
    },
    function () {});
}

//Search person by name
const searchPersonByName = () => {
  let text = $("#searchname")[0].value.toUpperCase();
  for (let i = 0; i < loadedUserCard.length; i++) {
    if (loadedUserCard[i].getAttribute("name").toUpperCase().indexOf(text) > -1) {
      loadedUserCard[i].style.display = "";
    } else {
      loadedUserCard[i].style.display = "none";
    }
  }
};

//Search category by name
const searchCategoryByName = () => {
  let text = $("#searchcat")[0].value.toUpperCase();
  let cats = $(".categoryCard");
  for (let i = 0; i < cats.length; i++) {
    if (cats[i].getAttribute("name").toUpperCase().indexOf(text) > -1) {
      cats[i].style.display = "";
    } else {
      cats[i].setAttribute('style', 'display: none !important');
    }
  }
};

//Search place by name
const searchPlaceByName = () => {
  let text = $("#searchPlace")[0].value.toUpperCase();
  cards = $(".placeCard");
  for (let i = 0; i < cards.length; i++) {
    if (cards[i].getAttribute("name").toUpperCase().indexOf(text) > -1) {
      cards[i].style.display = "";
    } else {
      cards[i].setAttribute('style', 'display: none !important');
    }
  }
};

//Category things
const editCategory = (id) => {
  let obj = placeTypes.find(x => x.id == id),
    box = document.createElement("div"),
    title = "Szerkesztés",
    boxInside = document.createElement("div"),
    p = document.createElement("p");

  boxInside.appendChild(p);
  if(typeof(obj)!="undefined"){
    p.innerHTML = "<input type='text' placeholder='Kategória név' class='form-control catName' required value='" + obj.name + "'></input>";
  }
  box.appendChild(boxInside);

  alertify.confirm(title, box, function () {
    if(typeof(obj)!="undefined"){
      sendRefreshedData("category", id)
    }
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });
};

const newCategory = () => {
  let box = document.createElement("div"),
    title = "Új kategória",
    boxInside = document.createElement("div");
  let p = document.createElement("p");

  boxInside.appendChild(p);
  p.innerHTML = "<input type='text' placeholder='Kategória név' class='form-control catName'></input>";
  box.appendChild(boxInside);
  alertify.confirm(title, box, function () {
    sendNewCategoryToServer()
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });
};

const sendNewCategoryToServer = () => {
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData: "newCategory",
      name: $(".catName")[0].value
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        alertify.notify('Sikeres módosítás!', 'success', 5);

        let newCategory = {
          id: parseInt(msg.response),
          name: $(".catName")[0].value
        };
        placeTypes.push(newCategory);
        makeCategoriesCard(newCategory.id, newCategory.name);
        if (document.getElementsByName("noCat")[0]) {
          document.getElementsByName("noCat")[0].remove();
        }
      } else {
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error',5);
        console.log("%c" + msg.response, "color:red");
      }
    }
  });
};

const removeCategory = (id, liid) => {
  alertify.confirm('Törlés', 'Biztosan törölni szeretnéd ezt a kategóriát?',
    function () {
      $.ajax({
        url: 'assets/changeDatas.php',
        type: 'POST',
        data: {
          wData: "removeCategory",
          id: id
        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            alertify.notify('Sikeres módosítás!', 'success', 5);
            if(typeof(placeTypes.findIndex(x => x.id == id))!="undefined"){
              placeTypes.splice(placeTypes.findIndex(x => x.id == id), 1);
              $("#" + liid).remove();
              if (placeTypes.length == 0) makeCategoriesCard(null, "noCat").children[0].innerHTML = "Jelenleg nincs egyetlen kategória sem <i class='fas fa-sad-tear fa-lg'></i>";
            }
          } else {
            alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
            console.log("%c" + msg.response, "color:red");
          }
        }
      });
    },
    function () {});
};

const getClasses = (type) => {
  if(type == "classSelectToSort"){
    let option = document.createElement("option");
    option.value = 0;
    option.innerHTML = "Mindenki";
    $("#classSelectToSort")[0].appendChild(option);
    
    for (let i = 0; i < classes.length; i++) {
      if(typeof(classes[i])!="undefined"){
        option = document.createElement("option");
        option.value = classes[i].id;
        option.innerHTML = classes[i].className;
        $("#classSelectToSort")[0].appendChild(option);
      }
    } 
  } 
};

const classSelectToSort = () =>{
  let select = $("#classSelectToSort")[0];
  let actual = select.options[select.selectedIndex].value;
  
    for (let i = 0; i < loadedUserCard.length; i++) {
      if (loadedUserCard[i].getAttribute("uclass")==actual||actual==0) {
        loadedUserCard[i].style.display = "";
      } else {
        loadedUserCard[i].style.display = "none";
      }
    }
  
};

//At the users panel, u can edit the user's datas
const editUserDatas = (datas)=>{
  let obj = people.find(x => x.id == datas);
  let box = document.createElement("div"),
  title = obj.name,
  boxInside = document.createElement("div");
  let p = document.createElement("p");
  let uClass = "";
  boxInside.appendChild(p);
  let select = document.createElement("select");
  $(select).addClass("form-control editUserClass");
  for (let i = 0; i < classes.length; i++) {

    let option = document.createElement("option");
    option.value = classes[i].id;
    option.innerHTML = classes[i].className;
    select.appendChild(option);
    if(classes[i].id==obj.class){
      option.setAttribute("class", "text-main-dark");
      option.selected = true;
    }
  }

p.innerHTML = "Név: <input type='text' placeholder='Név' class='form-control userName' required value='" + obj.name + "'></input>\n" +
"Email: <input type='text' placeholder='Email' class='form-control userEmail' required value='" + obj.email + "'></input>\nOsztály:";
boxInside.appendChild(select);
box.appendChild(boxInside);

alertify.confirm(title, box, function () {
  if(typeof(obj)!="undefined"){
    sendRefreshedData("user", obj.id)
  }
}, function () {}).set('labels', {
  ok: 'Tovább',
  cancel: 'Mégse'
});

};

const setAdmin = (that) => {
  $.ajax({
    url: 'assets/setAdmin.php',
    type: 'POST',
    data: {
      id: that.getAttribute("userID"),
      value: (that.value == "igen" ? 1 : 0)
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success == true) {
        alertify.notify('Sikeres módosítás!', 'success',5);
        $("#user" + that.getAttribute("userID"))[0].style.color = that.value == "igen" ? "#f71919" : "#007bff";

      } else {
        if (msg.response == "notAdmin") {
          alertify.notify('Hiba! Nem vagy admin.', 'error', 5);
        } else {
          alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    }
  });
};
const editClass = (id) => {
  let obj = classes.find(x => x.id == id),
    box = document.createElement("div"),
    title = "Szerkesztés",
    boxInside = document.createElement("div"),
    p = document.createElement("p");

  boxInside.appendChild(p);
  if(typeof(obj)!="undefined"){
    p.innerHTML = "<input type='text' placeholder='Osztály név' class='form-control className' required value='" + obj.className + "'></input>";
  }else{
    p.innerHTML= "Hiba!";
  }
  box.appendChild(boxInside);
  alertify.confirm(title, box, function () {
    if(typeof(obj)!="undefined"){
      sendRefreshedData("class", id)
    }
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });
};

const newClass = () =>{
  let box = document.createElement("div"),
    title = "Új osztály",
    boxInside = document.createElement("div");
  let p = document.createElement("p");

  boxInside.appendChild(p);
  p.innerHTML = "<input type='text' placeholder='Osztály név' class='form-control className'></input>";
  box.appendChild(boxInside);
  alertify.confirm(title, box, function () {
    sendNewClassToServer()
  }, function () {}).set('labels', {
    ok: 'Tovább',
    cancel: 'Mégse'
  });
};
const sendNewClassToServer = () => {
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData: "newClass",
      name: $(".className")[0].value
    },
    success: function (msg) {
      msg = JSON.parse(msg);
      if (msg.success) {
        alertify.notify('Sikeres módosítás!', 'success', 5); 
        let newClass = {
          id: parseInt(msg.response),
          className: $(".className")[0].value
        };
        if($(".noClass")[0]){
          $(".noClass")[0].remove();
        }
        classes.push(newClass);
        makeClassedCard(newClass.id, newClass.className);
      } else {
        alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
        console.log("%c" + msg.response, "color:red");
      }
    }
  });
};

const removeClass = (id, liid) => {
  alertify.confirm('Törlés', 'Biztosan törölni szeretnéd ezt az osztályt?',
    function () {
      $.ajax({
        url: 'assets/changeDatas.php',
        type: 'POST',
        data: {
          wData: "removeClass",
          id: id
        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            alertify.notify('Sikeres módosítás!', 'success', 5);
            if(typeof(classes.findIndex(x => x.id == id))!="undefined"){
            classes.splice(classes.findIndex(x => x.id == id), 1);
              $("#" + liid).remove();
              if (classes.length == 0) makeClassedCard(null, "noClass").children[0].innerHTML = "Jelenleg nincs egyetlen osztály sem <i class='fas fa-sad-tear fa-lg'></i>";
            }
          } else {
            alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
            console.log("%c" + msg.response, "color:red");
          }
        }
      });
    },
    function () {});
};


const removeEverybody = () => {
  alertify.confirm('Törlés', 'Biztosan lezárnád az évet, ezzel törölve minden felhasználót? Ez a beállítás végleges, és nem lehet visszaállítani!',
  function () {
    $.ajax({
      url: 'assets/changeDatas.php',
      type: 'POST',
      data: {
        wData: "removeEveryBody"
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          alertify.notify('Sikeres törlés', 'success', 5);
        } else {
          alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    });
  },
  function () {});

};

const removeUser = (id)  =>{
  alertify.confirm('Törlés', 'Biztosan törölni szeretnéd <span class="text-main-dark font-weight-bold">'+people.find(x => x.id == id).name+"</span> nevű felhasználót?",
    function () {
      $.ajax({
        url: 'assets/changeDatas.php',
        type: 'POST',
        data: {
          wData: "removeUser",
          id:id
        },
        success: function (msg) {
          msg = JSON.parse(msg);
          if (msg.success) {
            alertify.notify("Sikeres törlés!","success",5);
            $(".card"+id)[0].remove();
          }else{
            alertify.notify("Hiba! Szólj egy fejlesztőnek","error",5);
            console.log(msg.response);
          }
        }
      });
    },
    function () {});

};



