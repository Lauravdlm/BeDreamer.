-- Crear un usuario
CREATE USER 'test'@'localhost' IDENTIFIED BY '1234';

-- Conceder todos los privilegios sobre una base de datos
GRANT ALL PRIVILEGES ON bedreamer.* TO 'test'@'localhost';

-- Asignar privilegios para poder conectarse a localhost
GRANT USAGE ON *.* TO 'test'@'localhost';

-- Crear un rol
CREATE ROLE administrador;

-- Conceder privilegios al rol
GRANT SELECT, INSERT, UPDATE ON * TO administrador;

-- Asignar el rol a un usuario
GRANT administrador TO 'test'@'localhost';

-- Recargar los privilegios
FLUSH PRIVILEGES;

