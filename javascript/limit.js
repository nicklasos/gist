const async = require('async');

const concurrency = 3;
const wait = 700;

const queue = async.queue((task, done) => {

  setTimeout(() => {
    task.worker(done);
  }, wait);

}, concurrency);

const Limit = {
  work(worker) {
    queue.push({ worker });
  },
};

module.exports = Limit;

/*
// Usage

const limit = require('./limit');
limit.work((done) => {
  // work that needs to be limited
  done();
});
*/
