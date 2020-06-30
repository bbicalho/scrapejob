const https = require('https');
var json2xls = require('json2xls');
const fs = require('fs');
company = 'company';
//[11871,98555,14089,639,98556,29266,637,6446,31900,97826,647,97827,11871];
script(637);

function script(companyId){
		problem = [];
		ret = true;
		catcount = 0;//contador das categorias para organizar a sicronia, so começar uma nova categoria qdo a anterio estiver finalizada
		catmax = 10; //numero maximo de categorias
		pagmin = 0; //pagina inicial
		loadCount = 1; //contador para loading em prompt
		pag = pagmin;
		var complains =[];

		var url = 'https://iosearch.reclameaqui.com.br/raichu-io-site-search-v1/query/companyComplains/10/'+pag+'?company='+companyId;
		console.log(url);
		return false;
			https.get(url,  (res) => {
				let rawData = '';
			res.setEncoding('utf8');
			res.on('data', (chunk) => { rawData += chunk; });
		  res.on('end', () => {
			try {
				

			  const parsedData = JSON.parse(rawData);
			  let val = parsedData.complainResult.complains.problems;
			  company = parsedData.complainResult.complains.companies[0].name;
			  for(i=0;i<catmax;i++){//para repetir apenas 10 vezes
				problem.push(val[i]);
			  }
			  console.time('scrape'+companyId);
				console.log(problem[catcount].name+'('+problem[catcount].count+')');
				request(pag,problem[catcount]);
			  
			  
				
			  
			} catch (e) {
			  console.error(e.message);
			}
		  });
		}).on('error', (e) => {
		  console.error(`Got error: ${e.message}`);
		});

		/*
		categoria
		status
		local
		data
		titulo
		texto
		primeiraresposta
		ultimaresposta
		resoolvido
		voltaria
		nota
		*/






		function request(pag,val){
			
			
			var url = 'https://iosearch.reclameaqui.com.br/raichu-io-site-search-v1/query/companyComplains/10/'+pag+'?company='+companyId+'&problemType='+val.id;
			https.get(url,  (res) => {
				let rawData = '';
			res.setEncoding('utf8');
			res.on('data', (chunk) => { rawData += chunk; });
		  res.on('end', () => {
			try {
			  const parsedData = JSON.parse(rawData);
			  let data = parsedData.complainResult.complains.data;
			  if(!data.length
			  //|| pag==30
			  ){//limitação de pag para teste, sempre adicionando 0 ao final do numero da pagina
				  var xls = json2xls(complains);
					
					fs.writeFileSync('dist/'+company+'-'+val.name+'.xlsx', xls, 'binary');
					pag = pagmin;
					catcount++;
					complains =[];
					//process.stdout.write(loadCount+'/'+val.count);
					loadCount = 0;
					if(catcount<catmax){ //para quando chega a decima posição
						console.timeEnd('scrape'+companyId);
						console.log('\n');
						console.log(problem[catcount].name+'('+problem[catcount].count+')');
						console.time('scrape'+companyId);
						request(pag,problem[catcount]);
					}
					else{
						
					}
						
				  return false;
			  }
			  for(var i in data){
				loadCount+=1;
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
				
				getComplain(data[i],pag,val,data.length-1==i);
			  }
			  
			  
				
			  
			} catch (e) {
			  console.error(e.message);
			}
		  });
		}).on('error', (e) => {
		  console.error(`Got error: ${e.message}`);
		});
			
		}	

		function getComplain(data,pag,val,last){
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
					request(pag,val);
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
};