const mysql = require('mysql2');
const fs = require('fs');

// TODO : à lire depuis .env
// Configuration de la connexion à la base de données
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'admin',
    database: 'prototypecc'
});

connection.connect(err => {
    if (err) {
        console.error('Erreur de connexion à la base de données:', err);
        return;
    }
    console.log('Connecté à la base de données.');
    extractSchema();
});

const extractSchema = () => {
    // Requête pour obtenir la liste des tables
    connection.query('SHOW TABLES', (err, tables) => {
        if (err) {
            console.error('Erreur lors de la récupération des tables:', err);
            return;
        }

        const schema = {};
        let tablesProcessed = 0;

        tables.forEach(tableObj => {
            const tableName = tableObj[`Tables_in_${connection.config.database}`];

            // Requête pour obtenir les informations des colonnes de chaque table
            connection.query(`SHOW COLUMNS FROM \`${tableName}\``, (err, columns) => {
                if (err) {
                    console.error(`Erreur lors de la récupération des colonnes de la table ${tableName}:`, err);
                    return;
                }

                schema[tableName] = columns.map(column => ({
                    name: column.Field,
                    type: column.Type,
                    nullable: column.Null,
                    key: column.Key,
                    default: column.Default,
                    extra: column.Extra
                }));

                tablesProcessed++;

                // Une fois que toutes les tables sont traitées, écrire le fichier JSON
                if (tablesProcessed === tables.length) {
                    const jsonSchema = JSON.stringify(schema, null, 2);
                    fs.writeFile('schema.json', jsonSchema, 'utf8', err => {
                        if (err) {
                            console.error('Erreur lors de l\'écriture du fichier JSON:', err);
                            return;
                        }
                        console.log('Le schéma a été converti avec succès en JSON.');
                        connection.end();
                    });
                }
            });
        });
    });
};
