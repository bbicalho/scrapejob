  // await page.goto('https://www.reclameaqui.com.br/empresa/casas-bahia-loja-online/lista-reclamacoes/?pagina=1&problema=0000000000001457');
  
const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.goto('https://www.reclameaqui.com.br/empresa/casas-bahia-loja-online/lista-reclamacoes/?pagina=1&problema=0000000000001457', {waitUntil: 'networkidle2'});
  // await page.pdf({path: 'hn.pdf', format: 'A4'});
  
  // console.log(document.querySelector('#brand-page-controller > div.container.contained-items > div.row > div.col-xs-12.col-sm-12.col-md-12.col-lg-9.col-xg-9 > div.ng-scope > div > div:nth-child(2) > h1::text'));
  let title = await page.evaluate((sel) => {
        return document.querySelector('div.col-xs-12.col-sm-12.col-md-12.col-lg-9.col-xg-9').innerHTML;
      });
  
  console.log(title);

  await browser.close();
})();