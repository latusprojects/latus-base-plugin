export function buildQuery() {
    return new SearchQueryBuilder();
}

export class SearchQueryBuilder {
    #query = {};

    where(column, value, operator = '=') {
        this.#ensureKeyExistsInSubQuery('c', 'where');

        this.#query.c.where[column] = {value: value, op: operator};
    }

    whereIn(column, values) {
        this.#ensureKeyExistsInSubQuery('c', 'wherein');

        this.#query.c.wherein[column] = {value: values};
    }

    whereRelation(relation, column, value, operator = '=') {
        this.#ensureKeyExistsInSubSubQuery('w', relation, 'where');

        this.#query.w[relation].where[column] = {value: value, op: operator};
    }

    whereInRelation(relation, column, values) {
        this.#ensureKeyExistsInSubSubQuery('w', relation, 'wherein');

        this.#query.w[relation].wherein[column] = {value: values};
    }

    toJson() {
        return JSON.stringify(this.#query);
    }

    get() {
        return this.#query;
    }

    #ensureKeyExistsInSubQuery(key, subKey) {
        this.#ensureKeyExistsInQuery(key);

        if (!this.#query[key].hasOwnProperty(subKey)) {
            this.#query[key][subKey] = {};
        }
    }

    #ensureKeyExistsInSubSubQuery(key, subKey, subSubKey) {
        this.#ensureKeyExistsInSubQuery(key, subKey);

        if (!this.#query[key][subKey].hasOwnProperty(subSubKey)) {
            this.#query[key][subKey][subSubKey] = {};
        }
    }

    #ensureKeyExistsInQuery(key) {
        if (!this.#query.hasOwnProperty(key)) {
            this.#query[key] = {};
        }
    }
}