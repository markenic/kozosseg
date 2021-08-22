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

let places = [],
  placesCopy = [],
  resultPlaces = [],
  placeTypes = [],
  classes = [],
  successLoad = false,
  loaded = 0,
  lang;

  let loadEveryThing = () => {

    $.ajax({ //language
      url: 'assets/getText.php',
      type: 'POST',
      data: {
        get: true
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          lang = msg.response
          loaded++
        } else {

        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
          console.log("%c" + err, "color:red");
        }
      }
    });
  
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
          loaded++
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
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
          loaded++
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
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
          loaded++
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
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
          loaded++
        } else {
          if (msg.response) {
            console.log("Error: " + msg.response);
          } else {
            console.log(lang.errDevelop);
          }
        }
      },
      error: function (textStatus, err) {
        if (err == "error") {
          alertify.notify(lang.errDevelop, 'error', 5);
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
        alertify.notify(lang.noData, 'error', 12);     
      }
    },1000*10);
  
  };
  
  loadEveryThing();
  
  const checkFor = (that) =>{
    if(loaded >= 5){
      clearInterval(that);
      $(".loader-wrapper").fadeOut("slow");
      $("header").css("display","flex");
      buildSite();
      successLoad = true;
    }
  };
  
  const buildSite = () =>{
  
    //First of all, put the places
    placesCopy = places;
    const map = new Map();
    for (const item of places) {
      if (!map.has(item.place)) {
        if (item.type != -1) {
          map.set(item.place, true);
          resultPlaces.push(item.place);
        }
      }
    }
    loadPage();

    getClasses("registerClass");
  };

let option = [];
let table, td = [],
  tr = [],
  td2 = [],
  buttons = [];

const loadPage = () => {
  let placeCount = 0;
  places.forEach(element => {
    if (element.type != -1) placeCount++;
  });
  $("#placeCount")[0].innerHTML = placeCount;
  table = document.createElement("table");
  table.setAttribute("class", "innerPlaceTable");
  $(".placeTable")[0].appendChild(table);
  if (placeCount == 0 || placeTypes.length == 0) {
    let text = document.createElement("h5");
    text.style.textAlign = "center";
    text.style.margin = "20px";
    text.setAttribute("class", "text-main-dark");
    text.innerHTML = lang.noPlace
    $(".placeTable")[0].appendChild(text);
    return;
  }
  for (let i = 0; i < placeTypes.length; i++) {
    tr[i] = document.createElement("tr");
    td2[i] = document.createElement("td");
    td2[i].setAttribute("class", "font-weight-bold text-main-dark");
    td2[i].innerHTML = "<h5>" + placeTypes[i].name + "</h5>";
    tr[i].appendChild(td2[i]);
    table.appendChild(tr[i]);
    for (let k = 0; k < placesCopy.length; k++) {
      if (placesCopy[k].type == placeTypes[i].id) {
        td[k] = document.createElement("button");
        td[k].innerHTML = placesCopy[k].name + " - " + placesCopy[k].place;
        td2[i].appendChild(td[k]);
        td[k].id = placesCopy[k].id;
        td[k].setAttribute("class", "btn btn-light bg-light text-muted tdBtn");
        td[k].onclick = function () {
          makeInfoBox(this)
        };
      }
    }
  }
};
const makeInfoBox = (that) => {
  let obj = placesCopy.find(x => x.id == that.id);
  let box,title;
  if(typeof(obj)!="undefined"){
    box = document.createElement("div"),
      title = obj.name;
    boxInside = document.createElement("div");
    let p = document.createElement("p");
    boxInside.appendChild(p);
    p.innerHTML = lang.teacher+": <h6>" + teachers.find(x => x.id == obj.teacher).name + "</h6>\n"+lang.activity+": <h6>" + obj.name + "</h6>\n"+lang.place+": <h6>" + obj.place + "</h6>" + "\n"+lang.hour+": <input type='number' id='hourCount' class='form-control' placeholder="+lang.hour+">";
    box.appendChild(boxInside);
    alertify.confirm(title, box, function () {
      if ($("#hourCount")[0].value == "" || $("#hourCount")[0].value < 1) {
        alertify.notify(lang.nohour, "error", 5);
      } else {
        if(typeof(obj)!="undefined"){
          addPlace(obj);
        }
      }
    }, function () {}).set('labels', {
      ok: lang.ok,
      cancel: lang.cancel
    });
  }

};
let li = [];
let icons;
const loadList = () => {
  for (let i = 0; i < places.length; i++) {
    li[i] = document.createElement("li");
    li[i].setAttribute("class", "list-group-item d-flex justify-content-between");
    li[i].innerHTML = places[i].name + " - " + places[i].place;
    icons = document.createElement("span");
    icons.innerHTML = '<i class="fas fa-times"></i>';
    icons.setAttribute("class", "exit");
    li[i].appendChild(icons);
    $(".list")[0].appendChild(li[i]);
  }
};
let checks = [];
const sortByPlaces = () => {
  let box = document.createElement("div"),
    boxInside = document.createElement("div"),
    title = lang.places;
  checks = [];
  let labels = [],
    spans = [];
    resultPlaces.sort();
  for (let i = 0; i < resultPlaces.length; i++) {
    checks[i] = document.createElement("input");
    checks[i].setAttributes({
      'class': 'check',
      'type': 'checkbox',
      'id': resultPlaces[i]
    });
    labels[i] = document.createElement("label");
    labels[i].setAttribute("class", "cont");
    labels[i].innerHTML = resultPlaces[i] + " ";
    spans[i] = document.createElement("span");
    spans[i].setAttribute("class", "checkmark");
    boxInside.appendChild(labels[i]);
    labels[i].appendChild(checks[i]);
    labels[i].appendChild(spans[i]);
  }
  box.appendChild(boxInside);
  alertify.confirm(title, box, function () {
    let isChecked = false;
    for(let i=0;i<checks.length;i++){
      if(checks[i].checked==true){
        isChecked=true;
      }
    }
    if(isChecked){
      sort("place")
    }
  }, function () {}).set('labels', {
    ok: lang.ok,
    cancel: lang.cancel
  });;
};

const sort = (type) => {
  if (type == "place") {
    $(".innerPlaceTable")[0].remove();
    placesCopy = [];
    for (let i = 0; i < places.length; i++) {
      for (let k = 0; k < checks.length; k++) {
        if (places[i].place == checks[k].id && checks[k].checked) {
          placesCopy.push(places[i]);
        }
      }
    }
    loadPage();
  }
};

const removeFilters = () => {
  if (placesCopy.length != 0 && placeTypes.length != 0) {
    $(".innerPlaceTable")[0].remove();
    placesCopy = places;
    loadPage();
  }
};

const getClasses = () => {

  if ($(".class")[0]) {
    for (let i = 0; i < classes.length; i++) {
      if(typeof(classes[i])!="undefined"){
        let option = document.createElement("option");
        option.value = classes[i].id;
        option.innerHTML = classes[i].className;
        $(".class")[0].appendChild(option);
      }else if($(".setClass")[0]){

        $.ajax({
          url: 'assets/getPeople.php',
          type: 'POST',
          data: {
            wData: "own",
            session:true
          },
          success: function (msg2) {
            msg2 = JSON.parse(msg2);
            if (msg2.success) {
              let uclass = msg2.response[0].class;
              for (let i = 0; i < classes.length; i++) {
                if(typeof(classes[i])!="undefined"){
                  let option = document.createElement("option");
                  option.value = classes[i].id;
                  option.innerHTML = classes[i].className;
                  if(uclass==option.value){
                    option.selected=true;
                    option.setAttribute("selected","true");
                  }
                  $(".setClass")[0].appendChild(option);
                }
              }
            }
          }
        });
      }else if($("#classSelectToSort")){
        let option = document.createElement("option");
        option.value = 0;
        option.innerHTML = lang.everybody;
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
    }
  }
}

const addPlace = (that) => {
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData: "setUserPlaces",
      placeid: that.id,
      hour:$('#hourCount')[0].value
    },
    success: function (msg) {
      console.log(msg);
      msg = JSON.parse(msg);

      if (msg.success) {
        alertify.notify(lang.succLog, 'success', 5);
      } else {
        if (msg.response == "Not logined user") {
          alertify.notify(lang.noLog, 'error',5);
        }else if(msg.response == "Exist in table") {
          alertify.notify(lang.existInTable, 'error', 5);
        }else if(msg.response == "too much places") {
          alertify.notify(lang.muchPlace, 'error', 5);
        }else {
          alertify.notify(lang.errDevelop, 'error', 5);
          console.log("%c" + msg.response, "color:red");
        }
      }
    }
  });
};

const setLang = (lang) =>{
  $.ajax({
    url: 'assets/changeDatas.php',
    type: 'POST',
    data: {
      wData: "setLang",
      lang:lang
    },
    success: function (msg) {
      console.log(msg)
      msg = JSON.parse(msg);
      console.log(msg)
      if (msg.success) {
        location.reload();
      } else {
          alertify.notify(lang.errorDev, 'error',5);
      }
    }
  });


}
