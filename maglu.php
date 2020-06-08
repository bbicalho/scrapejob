<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit ( 0);


// if(!file_exists("arq.html"))
// {

    // $url = "https://www.glassdoor.com.br/Avalia%C3%A7%C3%B5es/Via-Varejo-Avalia%C3%A7%C3%B5es-E2002288.htm";
    // $ch = curl_init(); 
                // curl_setopt($ch, CURLOPT_URL,$url); 
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                // curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
                // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'); 
                
                // // Apply the XML to our curl call 
                // $res = curl_exec($ch); 
                // curl_close($ch);

    // file_put_contents("arq.html", $res);
// }
// else
// {
    // $res = file_get_contents("arq.html");
// }


// $res = file_get_contents("arq.html");

// while(stripos($res, '<span class="authorLocation">') > 0)
// {
    // $rev0 = substr($res, stripos($res,'<span class="authorLocation">')+strlen('<span class="authorLocation">'));
    // $rev0 = substr($rev0, 0, stripos($rev0,'</span>'));
    // echo htmlentities($rev0).'<BR>';
    
    // $res = substr($res, stripos($res,'<span class="authorLocation">')+strlen('<span class="authorLocation">')+10);
// }

// $res = file_get_contents("arq.html");
// // <span class="authorJobTitle middle reviewer">Ex-funcionário - Vendedor</span>
// while(stripos($res, '<span class="authorJobTitle middle reviewer">') > 0)
// {
    // $rev0 = substr($res, stripos($res,'<span class="authorJobTitle middle reviewer">')+strlen('<span class="authorJobTitle middle reviewer">'));
    // $rev0 = substr($rev0, 0, stripos($rev0,'</span>'));
    // echo htmlentities($rev0).'<BR>';
    
    // $res = substr($res, stripos($res,'<span class="authorJobTitle middle reviewer">')+strlen('<span class="authorJobTitle middle reviewer">')+10);
// }

// die();

// $rev0 = str_replace(',""__typename":"City"},"$ROOT_QUERY', "}", $rev0);



unlink('glassdoorfinalmglu.csv');
file_put_contents('glassdoorfinalmglu.csv', "\xEF\xBB\xBF", FILE_APPEND | LOCK_EX);


$reviews_array = array();
$reviews_array[] = array('datahora', 'titulo', 'jobEndingYear', 'status_funcionario', 'cargo_funcionario', 'cidade', 'rating', 'qualidadevida', 'cultura', 'oportunidades', 'remuneracao',  'altalideranca', 'recomenda', 'perspectiva', 'pros', 'cons', 'conselho', 'isCurrentJob', 'lengthOfEmployment', 'employmentStatus');
	
// $datahora // 6 de abril de 2020
// $titulo // "Bom"
// $status_funcionario // Ex-funcionário 
// $cargo_funcionario // Ajudante De Produção em Jundiaí, São Paulo
// $rating // 5.0
// $qualidadevida // Qualidade de vida
// $cultura // Cultura e valores
// $oportunidades // Oportunidades de carreira
// $remuneracao // Remuneração e benefícios
// $altalideranca // Alta liderança
// $recomenda // Recomenda
// $perspectiva // Perspectiva positiva
// $experiencia // Trabalhou na Via Varejo em período integral por mais de 8 anos
// $pros //Empresa flexível ,boa , atende bem os clientes, da voz aos funcionários
// $contas // Horário , comida , descanso , cobrança, líderes
// $conselho //Olhar mais os colaboradores

// $res = substr($books_xml, stripos($books_xml,'<resource>') + strlen('<resource>'));
// $res = substr($res, 0, stripos($res,'</resource>'));

for($j = 0;$j < 117;$j++)
{
    if($j == 0)
        $url = "https://www.glassdoor.com.br/Avalia%C3%A7%C3%B5es/Magazine-Luiza-Avalia%C3%A7%C3%B5es-E382606.htm";
    else
        $url = "https://www.glassdoor.com.br/Avalia%C3%A7%C3%B5es/Magazine-Luiza-Avalia%C3%A7%C3%B5es-E382606_P".$j.".htm";
    
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'); 
    
    // Apply the XML to our curl call 
    $res = curl_exec($ch); 
    curl_close($ch);

    for($i = 0;$i < 10;$i++)
    {
        $rev0 = substr($res, stripos($res,'.reviews.'.$i.'":{"isLegal'));
        $rev0 = str_replace('.reviews.'.$i.'":', "", $rev0);
        if($i < 9)
            $rev0 = substr($rev0, 0, stripos($rev0,':{"isLegal'));
        else
            $rev0 = substr($rev0, 0, stripos($rev0,'reviews.9.links'));
        
        //$rev0 = substr($rev0, 0, stripos($rev0,'"__typename":"City"},"$ROOT_QUERY')+strlen('"__typename":"City"},"$ROOT_QUERY'));
        // $rev0 = str_replace(',""__typename":"City"},"$ROOT_QUERY', "}", $rev0);

        // echo htmlentities($rev0);
        echo '<br>------------------------------------------------------------<br>';
        echo $url.'<BR>';
        echo $j.'-'.$i.'<BR>';

        $reviewID = substr($rev0, stripos($rev0,'"reviewId":') + strlen('"reviewId":'));
        $reviewID = substr($reviewID, 0, stripos($reviewID,',"reviewDateTime'));
        echo 'reviewID: '.$reviewID.'<BR>';
        
        $datahora = substr($rev0, stripos($rev0,'"reviewDateTime":"') + strlen('"reviewDateTime":"'));
        $datahora = substr($datahora, 0, stripos($datahora,'","ratingOverall'));
        
        $titulo = substr($rev0, stripos($rev0,'"summary":"') + strlen('"summary":"'));
        $titulo = substr($titulo, 0, stripos($titulo,'","summaryOriginal'));
        
        $jobEndingYear = substr($rev0, stripos($rev0,'"jobEndingYear":') + strlen('"jobEndingYear":'));
        $jobEndingYear = substr($jobEndingYear, 0, stripos($jobEndingYear,',"jobTitle'));
        if($jobEndingYear > 1)
            $status_funcionario = 'Ex-funcionário';
        else
            $status_funcionario = 'Funcionário';
        
        $cargo_funcionario = substr($rev0, stripos($rev0,'"text":"') + strlen('"text":"'));
        $cargo_funcionario = substr($cargo_funcionario, 0, stripos($cargo_funcionario,'","__typename'));
        
        $cidade = substr($rev0, stripos($rev0,'"type":"CITY","name":"') + strlen('"type":"CITY","name":"'));
        $cidade = substr($cidade, 0, stripos($cidade,'","__typename":"City'));
        
        $rating = substr($rev0, stripos($rev0,'"ratingOverall":') + strlen('"ratingOverall":'));
        $rating = substr($rating, 0, stripos($rating,',"ratingCeo'));
        
        $qualidadevida = substr($rev0, stripos($rev0,'"ratingWorkLifeBalance":') + strlen('"ratingWorkLifeBalance":'));
        $qualidadevida = substr($qualidadevida, 0, stripos($qualidadevida,',"ratingCultureAndValues'));
        
        $cultura = substr($rev0, stripos($rev0,'"ratingCultureAndValues":') + strlen('"ratingCultureAndValues":'));
        $cultura = substr($cultura, 0, stripos($cultura,',"ratingSeniorLeadership'));
        
        $oportunidades = substr($rev0, stripos($rev0,'"ratingCareerOpportunities":') + strlen('"ratingCareerOpportunities":'));
        $oportunidades = substr($oportunidades, 0, stripos($oportunidades,',"ratingCompensationAndBenefits'));
        
        $remuneracao = substr($rev0, stripos($rev0,'"ratingCompensationAndBenefits":') + strlen('"ratingCompensationAndBenefits":'));
        $remuneracao = substr($remuneracao, 0, stripos($remuneracao,',"employer'));
        
        $altalideranca = substr($rev0, stripos($rev0,'"ratingSeniorLeadership":') + strlen('"ratingSeniorLeadership":'));
        $altalideranca = substr($altalideranca, 0, stripos($altalideranca,',"ratingRecommendToFriend'));
        
        $recomenda = substr($rev0, stripos($rev0,'"ratingRecommendToFriend":"') + strlen('"ratingRecommendToFriend":"'));
        $recomenda = substr($recomenda, 0, stripos($recomenda,'","ratingCareerOpportunities'));
        
        $perspectiva = substr($rev0, stripos($rev0,'"ratingBusinessOutlook":"') + strlen('"ratingBusinessOutlook":"'));
        $perspectiva = substr($perspectiva, 0, stripos($perspectiva,'","ratingWorkLifeBalance'));
        
        $experiencia = substr($rev0, stripos($rev0,'"ratingBusinessOutlook":"') + strlen('"ratingBusinessOutlook":"'));
        $experiencia = substr($experiencia, 0, stripos($experiencia,'","ratingWorkLifeBalance'));
        
        $pros = substr($rev0, stripos($rev0,'"pros":"') + strlen('"pros":"'));
        $pros = substr($pros, 0, stripos($pros,'","prosOriginal'));
        
        $cons = substr($rev0, stripos($rev0,'"cons":"') + strlen('"cons":"'));
        $cons = substr($cons, 0, stripos($cons,'","consOriginal'));
        
        $conselho = substr($rev0, stripos($rev0,'"advice":"') + strlen('"advice":"'));
        $conselho = substr($conselho, 0, stripos($conselho,'","adviceOriginal'));
        
        $isCurrentJob = substr($rev0, stripos($rev0,'"isCurrentJob":') + strlen('"isCurrentJob":'));
        $isCurrentJob = substr($isCurrentJob, 0, stripos($isCurrentJob,',"lengthOfEmployment'));
        
        $lengthOfEmployment = substr($rev0, stripos($rev0,'"lengthOfEmployment":') + strlen('"lengthOfEmployment":'));
        $lengthOfEmployment = substr($lengthOfEmployment, 0, stripos($lengthOfEmployment,',"employmentStatus'));
        
        $employmentStatus = substr($rev0, stripos($rev0,'"employmentStatus":') + strlen('"employmentStatus":'));
        $employmentStatus = substr($employmentStatus, 0, stripos($employmentStatus,',"jobEndingYear'));
        // value="REGULAR" checked=""></option><option value="CONTRACT"></option><option value="INTERN"></option><option value="FREELANCE">
        
        //<li class="empReview cf" id="empReview_32852665"><div class="hreview"><div class="d-flex justify-content-between"><div><time class="date subtle small" datetime="Thu Apr 23 2020 07:42:13 GMT-0300 (Brasilia Standard Time)">23 de abril de 2020</time></div></div><div class="row mt"><div class="col-sm-1"><span class="sqLogo smSqLogo logoOverlay"><img alt="Via Varejo Logo" class="lazy lazy-loaded" data-original="https://media.glassdoor.com/sql/2002288/via-varejo-squarelogo-1558448582866.png" data-original-2x="https://media.glassdoor.com/sqll/2002288/via-varejo-squarelogo-1558448582866.png" data-retina-ok="true" src="https://media.glassdoor.com/sql/2002288/via-varejo-squarelogo-1558448582866.png" title="" style="opacity: 1;"></span></div><div class="col-sm-11 pl-sm-lg mx-0"><h2 class="h2 summary strong mt-0 mb-xsm"><a href="/Avalia%C3%A7%C3%B5es/Avalia%C3%A7%C3%A3o-funcion%C3%A1rio-Via-Varejo-RVW32852665.htm" class="reviewLink">"Boa experiência"</a></h2><div class="mr-xsm d-lg-inline-block"><span class="gdStars gdRatings subRatings__SubRatingsStyles__gdStars"><div class=" v2__EIReviewsRatingsStylesV2__ratingInfoWrapper"><div class="v2__EIReviewsRatingsStylesV2__ratingInfo" rel="nofollow"><div class="v2__EIReviewsRatingsStylesV2__ratingNum v2__EIReviewsRatingsStylesV2__small">3.0</div><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="3.0"></span></span><div font-size="sm" class="css-9iyzoc"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span><span class="SVGInline"><svg class="SVGInline-svg" style="width: 16;height: 16;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4.4 9.25l7.386 7.523a1 1 0 001.428 0L20.6 9.25c.5-.509.5-1.324 0-1.833a1.261 1.261 0 00-1.8 0l-6.3 6.416-6.3-6.416a1.261 1.261 0 00-1.8 0c-.5.509-.5 1.324 0 1.833z" fill-rule="evenodd" fill="currentColor"></path></svg></span></div></div><div class="subRatings module subRatings__SubRatingsStyles__subRatings"><div class="dummyHoverArea"></div><i class="beak subRatings__SubRatingsStyles__beak"></i><ul class="undecorated"><li><div class="minor">Qualidade de vida</div><span class="subRatings__SubRatingsStyles__gdBars gdBars gdRatings med" title="3.0"><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="3.0"></span></span><div font-size="sm" class="css-9iyzoc"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span></span></li><li><div class="minor">Cultura e valores</div><span class="subRatings__SubRatingsStyles__gdBars gdBars gdRatings med" title="2.0"><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="2.0"></span></span><div font-size="sm" class="css-1t57hvz"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span></span></li><li><div class="minor">Oportunidades de carreira</div><span class="subRatings__SubRatingsStyles__gdBars gdBars gdRatings med" title="2.0"><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="2.0"></span></span><div font-size="sm" class="css-1t57hvz"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span></span></li><li><div class="minor">Remuneração e benefícios</div><span class="subRatings__SubRatingsStyles__gdBars gdBars gdRatings med" title="2.0"><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="2.0"></span></span><div font-size="sm" class="css-1t57hvz"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span></span></li><li><div class="minor">Alta liderança</div><span class="subRatings__SubRatingsStyles__gdBars gdBars gdRatings med" title="2.0"><span class="gdStars gdRatings common__StarStyles__gdStars"><span class="rating"><span class="value-title" title="2.0"></span></span><div font-size="sm" class="css-1t57hvz"><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span><span role="button">★</span></div></span></span></li></ul></div></span></div><div class="d-lg-inline-block"><div class="author minor"><span class="authorInfo"><span class="authorJobTitle middle reviewer">Ex-funcionário - Analista De Mesa De Crédito</span>&nbsp;<span class="middle">em <span class="authorLocation">São Caetano do Sul</span></span></span></div></div><div><div class="row reviewBodyCell recommends"><div class="col-sm-4"><i class="sqLed middle sm mr-xsm red"></i><span>Não recomenda</span></div><div class="col-sm-4"><i class="sqLed middle sm mr-xsm yellow"></i><span>Perspectiva neutra</span></div></div></div><p class="mainText mb-0">Trabalhou na Via Varejo em meio período por mais de 3 anos</p><div class="v2__EIReviewDetailsV2__fullWidth v2__EIReviewDetailsV2__clickable"><p class="strong mb-0 mt-xsm">Prós</p><p class="mt-0 mb-xsm v2__EIReviewDetailsV2__bodyColor v2__EIReviewDetailsV2__lineHeightLarge v2__EIReviewDetailsV2__isCollapsed ">Equipe amigável, bons aprendizados na área de atuação.</p></div><div class="v2__EIReviewDetailsV2__fullWidth v2__EIReviewDetailsV2__clickable"><p class="strong mb-0 mt-xsm">Contras</p><p class="mt-0 mb-xsm v2__EIReviewDetailsV2__bodyColor v2__EIReviewDetailsV2__lineHeightLarge v2__EIReviewDetailsV2__isCollapsed ">Administração fechada, não é aberta a idéias, empresa nada flexível.</p></div><div class="v2__EIReviewDetailsV2__continueReading v2__EIReviewDetailsV2__clickable">Continuar lendo</div><div class="row mt-xsm mx-0"></div><div class="row justify-content-around justify-content-md-between mt-lg"><div class="shareContent d-flex justify-content-center"><div class="share-callout-inline"><div class="callout-container"><ul class="d-table social-share-icon-list p-0"><li class="cell"><a class="social-share-icon facebook-share" href="#shareOnFacebook" data-url="https://www.glassdoor.com.br/Avalia%C3%A7%C3%B5es/Avalia%C3%A7%C3%A3o-funcion%C3%A1rio-Via-Varejo-RVW32852665.htm" data-label="facebook"><span class="offScreen">Compartilhar no Facebook</span></a></li><li class="cell"><a class="social-share-icon twitter-share" href="https://twitter.com/share?url=https%3A%2F%2Fwww.glassdoor.com.br%2FAvalia%25C3%25A7%25C3%25B5es%2FAvalia%25C3%25A7%25C3%25A3o-funcion%25C3%25A1rio-Via-Varejo-RVW32852665.htm&amp;amp;text=Via%20Varejo+review+on+%23Glassdoor%3A+%22Boa experiência%22" data-label="twitter"><span class="offScreen">Compartilhar no Twitter</span></a></li><li class="cell whatsapp"><a class="social-share-icon whatsapp-share" href="whatsapp://send?text=https%3A%2F%2Fwww.glassdoor.com.br%2FAvalia%25C3%25A7%25C3%25B5es%2FAvalia%25C3%25A7%25C3%25A3o-funcion%25C3%25A1rio-Via-Varejo-RVW32852665.htm" data-action="share/whatsapp/share" data-label="whatsapp"><span class="offScreen">Compartilhar no WhatsApp</span></a></li><li class="cell"><a class="social-share-icon email-share" href="mailto:?Subject=Via Varejo review on Glassdoor&amp;body=Leia esta avaliação da Via Varejo no Glassdoor. %22Boa experiência%22&nbsp;https%3A%2F%2Fwww.glassdoor.com.br%2FAvalia%25C3%25A7%25C3%25B5es%2FAvalia%25C3%25A7%25C3%25A3o-funcion%25C3%25A1rio-Via-Varejo-RVW32852665.htm" data-label="email"><span class="offScreen">Compartilhar por e‑mail</span></a></li><li class="cell"><a class="social-share-icon link-share" href="https://www.glassdoor.com.br/Avalia%C3%A7%C3%B5es/Avalia%C3%A7%C3%A3o-funcion%C3%A1rio-Via-Varejo-RVW32852665.htm" data-label="link"><span class="offScreen">Copiar link</span></a></li><li class="cell linkCopySuccess"><span class="social-share-icon icon-check showDesk"></span><span>Link copiado</span></li></ul></div></div></div><div class="d-flex"><div class="mr-md"><button class="gd-ui-button  css-1fs0fu9">Útil </button></div><div><span class="flagContent" data-disp-type="review" data-id="32852665" data-member="true" data-review-link="/Avalia%C3%A7%C3%B5es/Avalia%C3%A7%C3%A3o-funcion%C3%A1rio-Via-Varejo-RVW32852665.htm" data-type="EMPLOYER_REVIEW"><button class="px-0 mx-0 simple gd-btn gd-btn-2 gd-btn-sm gd-btn-icon gradient" title="Sinalizar como inapropriada" type="button"><i class="icon-flag-content"><span>Sinalizar como inapropriada</span></i><i class="hlpr"></i><span class="offScreen">Sinalizar como inapropriada</span></button><span class="posPt"></span></span></div></div><span class="d-none"><span class="item"><span class="fn">Via Varejo</span></span><span class="dtreviewed">2020-04-23</span></span></div></div></div></div></li>
        if(strlen($cidade) > 60 || strlen($cidade) < 3 || empty($cidade))
        {
            $res_cidade = $res;
            $cidade = '';
            if(stripos($res_cidade,'<li class="empReview cf" id="empReview_'.$reviewID.'">') > 0)
            {
                $res_review = substr($res_cidade, stripos($res_cidade,'<li class="empReview cf" id="empReview_'.$reviewID.'">')+strlen('<li class="empReview cf" id="empReview_'.$reviewID.'">'));
                $res_review = substr($res_review, 0, stripos($res_review,'<li class="empReview cf"'));
                
                // echo htmlentities($res_review).'<BR>';
                if(stripos($res_review,'<span class="authorLocation">') > 0)
                {    
                    $rev_cidade = substr($res_review, stripos($res_review,'<span class="authorLocation">') + strlen('<span class="authorLocation">'));
                    $rev_cidade = substr($rev_cidade, 0, stripos($rev_cidade,'</span>'));
                    // echo htmlentities($rev_cidade).'<BR>';
                    $cidade = $rev_cidade;
                }
            }
        }
        
        if(strlen($cargo_funcionario) > 60 || strlen($cargo_funcionario) < 3 || empty($cargo_funcionario))
        {
            $res_cargo = $res;
            $cargo_funcionario = '';
            if(stripos($res_cargo,'<li class="empReview cf" id="empReview_'.$reviewID.'">') > 0)
            {
                $res_review = substr($res_cargo, stripos($res_cargo,'<li class="empReview cf" id="empReview_'.$reviewID.'">')+strlen('<li class="empReview cf" id="empReview_'.$reviewID.'">'));
                $res_review = substr($res_review, 0, stripos($res_review,'<li class="empReview cf"'));
                
                // echo htmlentities($res_review).'<BR>';
                
                if(stripos($res_review,'<span class="authorJobTitle middle reviewer">') > 0)
                {
                    $rev_cargo = substr($res_review, stripos($res_review,'<span class="authorJobTitle middle reviewer">') + strlen('<span class="authorJobTitle middle reviewer">'));
                    $rev_cargo = substr($rev_cargo, 0, stripos($rev_cargo,'</span>'));
                    // echo htmlentities($rev_cargo).'<BR>';
                    $cargo_funcionario = $rev_cargo;
                }
            }
        }
     
        // sanitize: 
        $titulo = str_replace(";"," ",$titulo);
        $pros = str_replace(";"," ",$pros);
        $cons = str_replace(";"," ",$cons);
        $conselho = str_replace(";"," ",$conselho);
        
        $titulo = str_replace("-"," ",$titulo);
        $pros = str_replace("-"," ",$pros);
        $cons = str_replace("-"," ",$cons);
        $conselho = str_replace("-"," ",$conselho);
        
        $titulo = str_replace("\n"," ",$titulo);
        $pros = str_replace("\n"," ",$pros);
        $cons = str_replace("\n"," ",$cons);
        $conselho = str_replace("\n"," ",$conselho);
        
        $titulo = str_replace("\r"," ",$titulo);
        $pros = str_replace("\r"," ",$pros);
        $cons = str_replace("\r"," ",$cons);
        $conselho = str_replace("\r"," ",$conselho);
        
        $titulo = str_replace("\t"," ",$titulo);
        $pros = str_replace("\t"," ",$pros);
        $cons = str_replace("\t"," ",$cons);
        $conselho = str_replace("\t"," ",$conselho);
        
        echo 'datahora: '.$datahora; echo '<BR>';
        echo 'titulo: '.$titulo; echo '<BR>';
        echo 'jobEndingYear: '.$jobEndingYear; echo '<BR>';
        echo 'status_funcionario: '.$status_funcionario; echo '<BR>';
        echo 'cargo_funcionario: '.$cargo_funcionario; echo '<BR>';
        echo 'cidade: '.$cidade; echo '<BR>';
        echo 'rating: '.$rating; echo '<BR>';
        echo 'qualidadevida: '.$qualidadevida; echo '<BR>';
        echo 'cultura: '.$cultura; echo '<BR>';
        echo 'oportunidades: '.$oportunidades; echo '<BR>';
        echo 'remuneracao: '.$remuneracao; echo '<BR>';
        echo 'altalideranca: '.$altalideranca; echo '<BR>';
        echo 'recomenda: '.$recomenda; echo '<BR>';
        echo 'perspectiva: '.$perspectiva; echo '<BR>';
        echo 'pros: '.$pros; echo '<BR>';
        echo 'cons: '.$cons; echo '<BR>';
        echo 'conselho: '.$conselho; echo '<BR>';
        echo 'isCurrentJob: '.$isCurrentJob; echo '<BR>';
        echo 'lengthOfEmployment: '.$lengthOfEmployment; echo '<BR>';
        echo 'employmentStatus: '.$employmentStatus; echo '<BR>';
        
        $reviews_array[] = array($datahora, $titulo, $jobEndingYear, $status_funcionario, $cargo_funcionario, $cidade, $rating, $qualidadevida, $cultura, $oportunidades, $remuneracao,  $altalideranca, $recomenda, $perspectiva, $pros, $cons, $conselho, $isCurrentJob, $lengthOfEmployment, $employmentStatus);
        
        $datahora = '';
        $titulo = '';
        $jobEndingYear = '';
        $status_funcionario = '';
        $cargo_funcionario = '';
        $cidade = '';
        $rating = '';
        $qualidadevida = '';
        $cultura = '';
        $oportunidades = '';
        $remuneracao = '';
        $altalideranca = '';
        $recomenda = '';
        $perspectiva = '';
        $pros = '';
        $cons = '';
        $conselho = '';
        $isCurrentJob = '';
        $lengthOfEmployment = '';
        $employmentStatus = '';
        
        // die();
    }
}

foreach($reviews_array as $row)
{
    file_put_contents('glassdoorfinalmglu.csv', implode(";",$row)."\n", FILE_APPEND | LOCK_EX);
}


?>
