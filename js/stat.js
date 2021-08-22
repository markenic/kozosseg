

let userPlaces = [],
  resultPlaces = [],
  places = [],
  matchPlace = [],
  countPlaces = [],
  people = [];


$(document).ready(function () {
  $.ajax({
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

        $.ajax({
          url: 'assets/getDatas.php',
          type: 'POST',
          data: {
            wData: "getPlaces",
            session: true
          },
          success: function (msg2) {

            msg2 = JSON.parse(msg2);
            if (msg2.success) {
              userPlaces = msg2.response;
              $.ajax({
                url: 'assets/getDatas.php',
                type: 'POST',
                data: {
                  wData: "places"
                },
                success: function (msg) {
                  msg = JSON.parse(msg);
      
                  if (msg.success) {
                    places = msg.response;
                    $("#placesCount")[0].innerHTML = places.length;
                    let subscriberCount = 0;

                    const subscribers = new Map();
                    for (const item of userPlaces) {
                      if (!subscribers.has(item.uid)) {
                          subscribers.set(item.uid, true);
                          subscriberCount++;
                        
                      }
                    }
                    $("#usersCount")[0].innerHTML = subscriberCount + " / " + people.length;
                    const map = new Map();
                    for (const item of places) {
                      if (!map.has(item.place)) {
                        if (item.type != -1) {
                          map.set(item.place, true);
                          resultPlaces.push(item.place);
                        }
                      }
                    }
                    for (let k = 0; k < places.length; k++) {
                      let match = userPlaces.filter(x => x.placeid == places[k].id)[0];
                      if (match != null){
                        matchPlace.push(match.placeid);
                      } 
                    }
      
                    
                    
                    countPlaces = matchPlace.reduce(function (prev, cur) {
                      prev[cur] = (prev[cur] || 0) + 1;
                      return prev;
                    }, {});
      
                    let labels = [];
                    let datas = [],
                      colors = [],
                      filtered = [];
      
                    let map2 = new Map();
                    for (const item of matchPlace) {
                      if (!map2.has(item)) {
      
                        map2.set(item, true);
                        filtered.push(item);
                      }
      
                    }
      
                    for (let i = 0; i < filtered.length; i++) {
      
                      let obj = places.find(x => x.id == filtered[i]);
      
                      labels[i] = obj.name + " - " + obj.place;
                      datas[i] = countPlaces[filtered[i]];
                      colors[i] = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.3)';
      
                    }
      
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                      type: 'pie',
                      data: {
                        labels: labels,
                        datasets: [{
                          data: datas,
                          backgroundColor: colors
                        }]
      
                      }
                    });
                    var ctx2 = document.getElementById('myChart2').getContext('2d');
                    var myChart2 = new Chart(ctx2, {
                      type: 'bar',
                      data: {
                        labels: labels,
                        datasets: [{
                          label: 'Jelentkező',
                          data: datas,
                          backgroundColor: colors
                        }]
                      },
                      options: {
                        scales: {
                          yAxes: [{
                            ticks: {
                              beginAtZero: true
                            }
                          }]
                        }
                      }
                    });
                  }
                }
              });

            } else {
              alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
              console.log("%c" + msg2.response, "color:red");
            }
          }
        });


      }
    }
  });
  let classes = [];
  const getClasses = () => {
    $.ajax({
      url: 'assets/getDatas.php',
      type: 'POST',
      data: {
        wData: "classes"
      },
      success: function (msg) {
        msg = JSON.parse(msg);
        if (msg.success) {
          classes = msg.response;
          if ($(".class")[0]) {
            for (let i = 0; i < classes.length; i++) {
              let option = document.createElement("option");
              option.value = classes[i].id;
              option.innerHTML = classes[i].className;
              $(".class")[0].appendChild(option);
            }
            $.ajax({
              url: 'assets/getDatas.php',
              type: 'POST',
              data: {
                wData: "places"
              },
              success: function (msg) {
                msg = JSON.parse(msg);
          
                if (msg.success) {
                  places = msg.response;
                  showClassStats();
                }
              }
            });
            

          }
        }
      }
    });

  }
  getClasses();


});

let classChart;
let selected = "1";
const showClassStats = () => {

  if (typeof $(".class")[0].options[$(".class")[0].selectedIndex] != 'undefined') {
    selected = $(".class")[0].options[$(".class")[0].selectedIndex].value;
  }

  let labels = [];
  let datas = [],
    colors = [],
    filtered = [],
    userPlaces = [],
    countPlaces = [],
    matchPlace = [],
    valami = [],
    map2 = null,
    userPlaces2 = [];

    $.ajax({
      url: 'assets/getDatas.php',
      type: 'POST',
      data: {
        session:true,
        wData: "getPlaces"
      },
      success: function (msg) {
        msg = JSON.parse(msg);
  
        if (msg.success) {
          userPlaces = msg.response;

          for (let i = 0; i < people.length; i++) {
            for (let k = 0; k < userPlaces.length; k++) {
              if(people[i].id==userPlaces[k].uid){
                if(people[i].class==selected){
                  userPlaces2.push(userPlaces[k]);
                }
                
              }
            }
          }
          console.log(userPlaces2);
          for (let k = 0; k < places.length; k++) {
            let match = userPlaces2.filter(x => x.placeid == places[k].id)[0];
            if (match != null) matchPlace.push(match.placeid);
          }
          
          countPlaces = matchPlace.reduce(function (prev, cur) {
            prev[cur] = (prev[cur] || 0) + 1;
            return prev;
          }, {});
          console.log(matchPlace);
          map2 = new Map();
          for (const item of matchPlace) {
            if (!map2.has(item)) {
              map2.set(item, true);
              filtered.push(item);
            }
          }
        
          if(filtered.length==0){
            if(typeof($('.noData')[0])=="undefined"){
              let text = document.createElement("p");
              text.innerHTML="Nincs megjeleníthető adat!";
              text.setAttribute("class","noData");
              text.style.color="black";
              text.style.textAlign="center";
              text.style.paddingTop="20px";
              $('.canvasdiv')[0].appendChild(text);
              if($('#classChart')[0]){
                $('#classChart')[0].remove();
              }
            }
        
            //document.getElementById('classChart').style.display="none";
          }else{
            if(typeof($('#classChart')[0])=="undefined"){
              let canvas = document.createElement("canvas");
              canvas.id="classChart";
              $('.canvasdiv')[0].appendChild(canvas);
        
              if(typeof($('.noData')[0])!="undefined"){
                $('.noData')[0].remove();
              }
            }
          }
          for (let i = 0; i < filtered.length; i++) {
            let obj = places.find(x => x.id == filtered[i]);
            labels.push(obj.name + " - " + obj.place);
            valami.push(obj.id);
            datas.push(countPlaces[filtered[i]]);
            colors.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.3)');
          }
          if (typeof (classChart) != "undefined") {
            classChart.destroy();
          }
          if($('#classChart')[0]){
            var ctx = document.getElementById('classChart').getContext('2d');
            classChart = new Chart(ctx, {
              type: 'pie',
              data: {
                labels: labels,
                class: valami,
                datasets: [{
                  data: datas,
                  backgroundColor: colors
                }]
        
              },
              options: {
                onClick: function (e, items) {
                  if (items.length == 0) return;
                  let label = document.createElement("div");
                  let p = document.createElement("p");
                  p.style.fontWeight = "bold";
                  label.appendChild(p);
                  let index = items[0]._index;
                  let placeid = items[0]._chart.chart.config.data.class[index];
                  for (let k = 0; k < userPlaces.length; k++) {
                    if (userPlaces[k] != "undefined" && typeof (userPlaces[k]) != "undefined") {
                      if (placeid == userPlaces[k].placeid) {
                        p.innerHTML += people.find(x => x.id == userPlaces[k].uid).name + "<br>";
                      }
                    }
                  }
                  alertify.alert("Jelentkezők", label, function () {});
                }
              },
            });
          }
        }
      }
    });
};
