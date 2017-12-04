const request = require('../src/lib/http-request');

const sinon = require('sinon');
const sandbox = sinon.sandbox.create();

describe('http request', () => {
  afterEach(() => sandbox.restore());

  describe('GET', () => {
    it('should make GET request', () => {

      sandbox.stub(request, 'foo').returns('x');
      
      request.bar();
      
      sinon.assert.calledOnce(request.foo);
      
    });

  });
});
