const current = {};

module.exports = function (name, seconds, callback) {
  if (!current.hasOwnProperty(name)) {
    current[name] = true;

    setTimeout(() => {
      delete current[name];
  }, seconds * 1000);

    callback();
  }
};