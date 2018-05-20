$("document").ready(function()
{
$("#nomm").keyup(function()
{
if ($(this).val().length > 0)
{
    var array = $(location).attr('href');
    var arra = array.split("/");
    var arr = arra[8];
    $(".food_list").empty();
    $.ajax(
        {
            type: 'get',
            url :'http://localhost/Bons_Plans/web/app_dev.php/BonsPlans/JE/' + $(this).val() + '/' + arr,
            async : false,
            beforeSend: function()
            {
                console.log('ça Charge');
            },
            success:function(response)
            {
                //$("#hg").text(data.et);
                $.each(response, function(a, b)
                {
                            $.each(b, function (c, d)
                            {
                                $(".food_list").append(
                                    "<div class=\"col-sm-3 col-xs-6 xs-padding\">" +
                                    "<div class=\"food_content align-center\">" +
                                    "<a href='/Bons_Plans/web/app_dev.php/BonsPlans/AfficherEtablissementClient/" + d.id + "'>" + "<img style=\"height: 200px;width: 230px;\" src='/Bons_Plans/web/img/" + d.imagePrincipale + "'>" + "</a>" +
                                    "<h3>" + "<a style=\"color: #303133\" href='/Bons_Plans/web/app_dev.php/BonsPlans/AfficherEtablissementClient/" + d.id + "'>" + d.nom + "</a>" + "</h3>" +
                                    "<h4 id=\"hg\" style=\"margin-bottom: 5px\" class=\"price\">" + d.budgetmoyen + "DT</h4>" +
                                    "<p style=\"font-weight: bold\">" + d.horaireOuverture.substring(0,5) + "-" + d.horaireFermeture.substring(0,5) + "</p>" +
                                    "</div>" + "</div>"
                                );
                            });
                }
                );
            }
        }
    );
}
else
    {
        var route = $(location).attr('href');
        var rout = route.split("/");
        var rou = rout[8];
        $(".food_list").empty();
        $.ajax(
            {
                type: 'get',
                url :'http://localhost/Bons_Plans/web/app_dev.php/BonsPlans/JEF/' + rou,
                beforeSend: function()
                {
                    console.log('ça Charge');
                },
                success:function(response)
                {
                    //$("#hg").text(data.et);
                    $.each(response, function(a, b)
                        {
                            $.each(b, function (c, d)
                            {
                                $(".food_list").append(
                                    "<div class=\"col-sm-3 col-xs-6 xs-padding\">" +
                                    "<div class=\"food_content align-center\">" +
                                    "<a href='/Bons_Plans/web/app_dev.php/BonsPlans/AfficherEtablissementClient/" + d.id + "'>" + "<img style=\"height: 200px;width: 230px;\" src='/Bons_Plans/web/img/" + d.imagePrincipale + "'>" + "</a>" +
                                    "<h3>" + "<a style=\"color: #303133\" href='/Bons_Plans/web/app_dev.php/BonsPlans/AfficherEtablissementClient/" + d.id + "'>" + d.nom + "</a>" + "</h3>" +
                                    "<h4 id=\"hg\" style=\"margin-bottom: 5px\" class=\"price\">" + d.budgetmoyen + "DT</h4>" +
                                    "<p style=\"font-weight: bold\">" + d.horaireOuverture + "-" + d.horaireFermeture + "</p>" +
                                    "</div>" + "</div>"
                                );
                            });
                        }
                    );
                }
            }
        );
    }
}
);
}
);