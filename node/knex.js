const config = require('./config');

const db = config.db[process.env.NODE_ENV || 'dev'];

const knex = require('knex')({
  client: 'mysql',
  connection: {
    supportBigNumbers: true,
    bigNumberStrings: true,
    host: db.host,
    user: db.user,
    password: db.password,
    database: db.database,
    multipleStatements: true,
    connectionLimit: 100,
  },
  pool: {
    min: 0,
    max: 10,
  },
});

/**
 * const db = require('./db');
 *
 * const { where } = db.wheresify('users');
 *
 * where({id: 1}).asCallback((err, result) => {
 *  console.log(result);
 * });
 *
 * @param name
 * @returns {{where: (function(...[*]): *), whereIn: (function(*=, *=): *), insert: (function(*=): *), batchInsert: (function(*=, *=): *)}}
 */
function wheresify(name) {
  return {
    where: (...params) => knex(name).where(...params),
    whereIn: (field, params) => knex(name).whereIn(field, params),
    insert: params => knex(name).insert(params),
    batchInsert: (params, chunk) => knex.batchInsert(name, params, chunk),
  };
}

module.exports = knex;
module.exports.wheresify = wheresify;
