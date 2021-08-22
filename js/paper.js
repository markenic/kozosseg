 $(document).ready(function() {
    let places = [], wantedPlaces = [];
    if($("#userid")[0]) {
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
              $.ajax({
                  url: 'assets/getPeople.php',
                  type: 'POST',
                  data: {
                    session: true,
                    wData: "onePerson",
                    userid: $("#userid")[0].value
                  },
                  success: function (msg) {
                    
                    msg = JSON.parse(msg);
                    console.log(msg);
                    if (msg.success) {
                      $.ajax({
                        url: 'assets/getDatas.php',
                        type: 'POST',
                        data: {
                          wData: "getUserPlaces",
                          uid:$("#userid")[0].value
                        },
                        success: function (msg2) {
                          msg2 = JSON.parse(msg2);
                          console.log(msg2);   
                          if (msg2.success) {
                            wantedPlaces = msg2.response;

                            let placeDivs = [];
                            console.log(wantedPlaces);
                            for (let i = 0; i < wantedPlaces.length; i++) {
                                obj = places.find(x => x.id == wantedPlaces[i].placeid);
                                
                                placeDivs[i] = document.createElement("li");
                                placeDivs[i].innerHTML=obj.name + " " + obj.place + " területen(" + wantedPlaces[i].placeid+") "+ wantedPlaces[i].hour + " órában"
                                $(".places")[0].appendChild(placeDivs[i]);
                            }
                            $(".schoolYear")[0].innerHTML=getSchoolYear();
                          }
                        }
                      });


                    } else {
                      alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
                      console.log("%c" + msg.response, "color:red");
                    }
                  }
              });
            }
          }
      });
    }else{
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
            $.ajax({
                url: 'assets/getDatas.php',
                type: 'POST',
                data: {
                  wData: "userPlaces"
                },
                success: function (msg) {
                  msg = JSON.parse(msg);
                  if (msg.success) {
                    wantedPlaces = msg.response;
                    obj = places.find(x => x.id == wantedPlaces.placeid);
                    let placeDivs = [];
                    for (let i = 0; i < wantedPlaces.length; i++) {
                        obj = places.find(x => x.id == wantedPlaces[i].placeid);
                        placeDivs[i] = document.createElement("li");
                        placeDivs[i].innerHTML=obj.name + " " + obj.place + " területen(" + wantedPlaces[i].placeid+") "+ wantedPlaces[i].hour + " órában"
                        $(".places")[0].appendChild(placeDivs[i]);
                    }
                    $(".schoolYear")[0].innerHTML=getSchoolYear();

                  } else {
                    alertify.notify('Hiba! Keress fel egy fejlesztőt!', 'error', 3);
                    console.log("%c" + msg.response, "color:red");
                  }
                }
            });
          }
        }
    }); 
    }
});

const getSchoolYear = () =>{
    let today = new Date();
    let yyyy = today.getFullYear();
    if(today.getMonth()+1>6&&today.getDate()>21){
        yyyy++;
    }
    return (yyyy-1+"/"+yyyy);
}