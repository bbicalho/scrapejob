const puppeteer = require('puppeteer');
const {performance} = require('perf_hooks');

(async () => {
  const browser = await puppeteer.launch();

  const page = await browser.newPage();
  
//turns request interceptor on
await page.setRequestInterception(true);

//if the page makes a  request to a resource type of image then abort that request
page.on('request', request => {
    if (request.resourceType() === 'image' || request.resourceType() === 'stylesheet')
    request.abort();
  else
    request.continue();
});
await read(1);	



async function read(pag){
	var arr = [];
	await page.goto('https://www.reclameaqui.com.br/empresa/casas-bahia-loja-online/lista-reclamacoes/?pagina='+pag);
	await page.evaluate(() => {
		var filter = document.querySelectorAll('.complain-filter-dropdown .company-filter-title');
		for(var i in filter){
			if(filter[i].firstElementChild && filter[i].firstElementChild.innerText.indexOf('Problemas')> -1)
				filter[i].nextElementSibling.querySelector('input').click();
		}			
	});
	console.time('scrap');
	for(var i=1;i<=10;i++){	
		await page.waitForSelector('.complain-list');
		await page.evaluate((i) => {
			document.querySelector('.complain-list:not(.ng-hide) li:nth-of-type('+i+') a').click();
		},i);
		await page.waitForSelector('.complain-head');
		var ret = await page.evaluate(() => {
			return document.querySelector('.complain-head h1').innerHTML;
		});
		arr.push(ret);
		await page.goBack();
	}
	console.timeEnd('scrap');
	
	
	await read(pag+1);	
	
	
	
}

  await browser.close();
})();