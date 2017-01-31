$(function(){
			
			$("#from,#to").change(function(){
				var value=($(this).val()).trim();
				if(value.length == 8) {
					var d = value[0]+""+value[1];
					var m =  value[2]+""+value[3];
					var y = value[4]+""+value[5]+value[6]+value[7];
					if(d == 0){
						d = "01";
					}
					if(m == 0){
						m = "01";
					}
					if(y < 1950){
						y = "1950";
					}
					value = d + "/" + m + "/" + y;
					var test = new Date(value);
					console.log(test == undefined);
					$(this).val(value);
				}else{
					$(this).val(value);
				}
		    });

            $("#next").click(function(){
                Calculate();
            });

            function Calculate() {
                var from = $("#from").val();
                    fromtime = $("#fromTime").val();
                    to = $("#to").val();
                    totime = $("#toTime").val();

                
                if(from != "" && fromtime != "" && to != "" && totime != ""){
                    var fromdate = (from+" "+fromtime).trim();
                        todate = (to+" "+totime).trim();
                        dateString = fromdate,
                        dateTimeParts = dateString.split(' '),
                        timeParts = dateTimeParts[1].split(':'),
                        dateParts = dateTimeParts[0].split('/'),

                    from = new Date(dateParts[2], parseInt(dateParts[1], 10) - 1, dateParts[0], timeParts[0], timeParts[1]);

                    var dateString = todate,
                        dateTimeParts = dateString.split(' '),
                        timeParts = dateTimeParts[1].split(':'),
                        dateParts = dateTimeParts[0].split('/'),

                    to = new Date(dateParts[2], parseInt(dateParts[1], 10) - 1, dateParts[0], timeParts[0], timeParts[1]);
                    //alert(to.getTime()-from.getTime());
                    if((to.getTime()-from.getTime()) < 0){
                        $("#next").hide();
                        $("#requireDate").show();
                        $("#requireDate").html("<p><font color=\"red\">วันที่เริ่มต้นหรือวันที่สิ้นสุดไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง</font></p>");
                    }else{
                        $("#next").show();
                        $("#requireDate").hide();
                    }
                }
            }

            $("#from,#to,#fromTime,#toTime").change(function(){
                Calculate();
            });

            $("#projectname,#description,#teamname").change(function(){
                var value=($(this).val()).trim();
                $(this).val(value);
            });

            $("#want").click(function(){
                $("#teamname").prop('disabled', false);
            });

            $("#nowant").click(function(){
                $("#teamname").prop('disabled', true);
                $("#teamrequire").hide();
            });

            $("#teamname").click(function(){
                $("#teamrequire").hide();
            });

            $("#submit").click(function(){
                var isDisabled = $("#teamname").is(':disabled');
                var teamname = ($("#teamname").val()).trim();

                if(isDisabled || teamname != ""){
                    alert("success");
                }else{
                    $("#teamrequire").html("<font color=\"red\">กรุณากรอกชื่อทีม</font>");
                    $("#teamrequire").show();
                }
            });
        });