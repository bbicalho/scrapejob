const https = require('https');
var json2xls = require('json2xls');
const fs = require('fs');
company = 'company';
//[11871,98555,14089,639,98556,29266,637,6446,31900,97826,647,97827,11871];
company = [
	/*{nome:'casas-bahia-loja-online',id:'11871'},
	{nome:'casas-bahia-lojas-fisicas',id:'3335'},
	{nome:'casas-bahia-marketplace',id:'98555'},
	{nome:'ponto-frio-loja-online',id:'14089'},
	{nome:'ponto-frio-lojas-fisicas',id:'639'},
	{nome:'ponto-frio-marketplace',id:'98556'},
	{nome:'magazine-luiza-loja-online',id:'29266'},
	{nome:'magazine-luiza-loja-fisica',id:'637'},
	{nome:'americanas-com-loja-online',id:'6446'},
	{nome:'lojas-americanas-loja-fisica',id:'31900'},
	{nome:'americanas-marketplace',id:'97826'},
	{nome:'submarino',id:'647'},
	{nome:'submarino-marketplace',id:'97827'},*/
	{nome:'netshoes',id:'8383'},
	{nome:'zattini',id:'88371'},
	{nome:'mercado-livre',id:'928'},
	{nome:'shoptime',id:'1634'},
	{nome:'shoptime-marketplace',id:'97828'},
	{nome:'extra-loja-online',id:'8789'},
	{nome:'extra-com-br-marketplace',id:'98553'},
	

]

var ret = true;
var pagmin = 0; //pagina inicial
var pag = pagmin;
var companyCount = 0;
var complains = [];
console.log('\x1b[32m','\n\nPROCESSANDO: '+company[companyCount].nome);
console.log('\x1b[0m');
//console.time('scrape');
request(pag);






		function request(pag){
			var url = 'https://iosearch.reclameaqui.com.br/raichu-io-site-search-v1/query/companyComplains/10/'+pag+'?company='+company[companyCount].id;
			https.get(url,  (res) => {
				let rawData = '';
			res.setEncoding('utf8');
			res.on('data', (chunk) => { rawData += chunk; });
		  res.on('end', () => {
			try {
			   process.stdout.write("\r\x1b[K")
			   process.stdout.write('Página '+pag/10);	
			   
			  const parsedData = JSON.parse(rawData);
			  let data = parsedData.complainResult.complains.data;
			  if((pag/10)-pagmin==1000){//a cada 1000 ele manda gerar
				  generate(); //gera
				  pagmin = pag/10//adiciona a contagem minima a cada 1000
				  pag = ((pag/10)+1)*10;//anda uma pagina
				  console.log(' gerando');
				  request(pag); //manda fazer
				  return false;
			  }
			  if(!data.length
			  //|| pag==50
			  ){//limitação de pag para teste, sempre adicionando 0 ao final do numero da pagina
				  console.log('\nFINALIZADO');
				  generate(true);
						
				  return false;
			  }
			  for(var i in data){
				for(var y in parsedData.complainResult.complains.problems){
					
					if(parsedData.complainResult.complains.problems[y].id && data[i].problemType &&
					(parsedData.complainResult.complains.problems[y].id.toString() == data[i].problemType.toString())){
						data[i]['problem'] = parsedData.complainResult.complains.problems[y].name;
						break;
					}
				}
				
				for(var y in parsedData.complainResult.complains.categories){
					if(parsedData.complainResult.complains.categories[y].id && data[i].category &&
					(parsedData.complainResult.complains.categories[y].id.toString() == data[i].category.toString())){
						data[i]['category'] = parsedData.complainResult.complains.categories[y].name;
						break;
					}
				}
				
				for(var y in parsedData.complainResult.complains.products){
					if(parsedData.complainResult.complains.products[y].id && data[i].productType &&
					(parsedData.complainResult.complains.products[y].id.toString() == data[i].productType.toString())){
						data[i]['type'] = parsedData.complainResult.complains.products[y].name;
						break;
					}
				}
				
				getComplain(data[i],pag,data.length-1==i);
			  }
			  
			  
				
			  
			} catch (e) {
			  console.error(e.message);
			  generate(true);
			}
		  });
		}).on('error', (e) => {
		  console.error(`Got error: ${e.message}`);
		});
			
		}	
		
		function generate(novo=false){
			var xls = json2xls(complains);
			fs.writeFileSync('dist/'+company[companyCount].nome+' - '+pagmin+'.xlsx', xls, 'binary');
			
			
			complains =[];

			if(novo && companyCount<(parseFloat(company.length)-1)){ //para quando ainda nao estiver lido todas empresas
				//console.timeEnd('scrape');
				companyCount++;
				console.log('\x1b[32m','\n\nPROCESSANDO: '+company[companyCount].nome);
				console.log('\x1b[0m','');
				//console.time('scrape');
				pagmin = 0;
				pag = 0;
				request(pag);
			}
			else{
				
			}
		}

		function getComplain(data,pag,last){
			var comment = '';
			var url = 'https://iosite.reclameaqui.com.br/raichu-io-site-v1/complain/public/'+data.id;
			//console.log(url);
			https.get(url,  (res) => {
				let rawData = '';
			res.setEncoding('utf8');
			res.on('data', (chunk) => { rawData += chunk; });
		  res.on('end', () => {
			try {
			  const parsedData = JSON.parse(rawData);
			  let comp = parsedData.interactions;
			  for(var i in comp){
				 //process.stdout.write("\r\x1b[K")
				//process.stdout.write(loadCount.toString());	
				  if(!comp[i].deleted){
					  date = comp[i].modified?comp[i].modified:comp[i].created;
					 comment+=comp[i].type+' | '+date+' | \n'+arrangeTags(comp[i].message)+'\n\n'; 
				  }
			  }
			   complains.push({
						'companyname':data.companyName,
						'link':('https://www.reclameaqui.com.br/'+data.fantasyName+'/'+data.title+'_'+data.id).replace(' ','-'),
						'tipo':data.type,
						'problema':data.problem,
						'categoria':data.category,
						'status':data.status,
						'local':data.userCity+'-'+data.userState,
						'data':data.created,
						//'primeiraresposta':data.firstInteractionDate,
						'resolvido':data.solved,
						'voltaria':data.dealAgain,
						'nota':data.score,
						'titulo':data.title,
						'texto':arrangeTags(data.description),
						'comentarios':comment
					  });
				if(last){
					pag = ((pag/10)+1)*10;
					request(pag);
				}
			  
			} catch (e) {
			  console.error(e.message);
			}
		  });
		}).on('error', (e) => {
		  console.error(`Got error: ${e.message}`);
		});
		}
		function arrangeTags(str){
			str = str.replace('<br />','\n');
			str = str.replace(/(<([^>]+)>)/ig,"");
			return str
		}
