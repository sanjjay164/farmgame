$(document).ready(function(){

});

function site_url()
{
	return "http://localhost/farmgame";
}

function play()
{
	$.ajax({  
				type: "POST",  
				url: SITE_URL+"farmgame.php?function=play",  
				dataType:"json",  
				data: ({ data: "data"}),  
				beforeSend: function(){			 					
				
				},
				success: function (response) {
					if(response.s == "1")
					{
						$("#total_turn_left").text(response.d.total_turn_left);
						var current_row = TOTAL_TURNS - response.d.total_turn_left;
						if(typeof(response.d.game_over) != "undefined" && response.d.game_over=="1")
						{
							alert(response.m);
							$("#sub_play").prop("disabled",true);
							//location.reload();
							return;
						}
						//if(response.d.farm_data.member_got_killed == "0")
						//{
							$("[data-member='"+current_row+"-"+response.d.feed_member+"'] ").text("feed")
						//}
						if(typeof(response.d.member_killed) != "undefined" )
						{
							for(i in response.d.member_killed)
							{
								$("[data-member='"+current_row+"-"+response.d.member_killed[i]+"'] ").text("killed");
							}
							
						}
						
					}
					else
					{
						alert(response.m);
					}
				}
			});
}
