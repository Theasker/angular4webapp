import { CursoAngular4WebappPage } from './app.po';

describe('curso-angular4-webapp App', () => {
  let page: CursoAngular4WebappPage;

  beforeEach(() => {
    page = new CursoAngular4WebappPage();
  });

  it('should display welcome message', done => {
    page.navigateTo();
    page.getParagraphText()
      .then(msg => expect(msg).toEqual('Welcome to app!!'))
      .then(done, done.fail);
  });
});
