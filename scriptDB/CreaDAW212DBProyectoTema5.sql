CREATE DATABASE IF NOT EXISTS DAW213DBProyectoTema5;

USE DAW213DBProyectoTema5;

CREATE USER 'usuarioDAW213DBProyectoTema5'@'%' IDENTIFIED BY 'paso';

GRANT ALL PRIVILEGES ON `DAW213DBProyectoTema5`.* TO 'usuarioDAW213DBProyectoTema5'@'%';

CREATE TABLE Departamento (
  CodDepartamento VARCHAR(3) PRIMARY KEY,
	DescDepartamento VARCHAR(255) NOT NULL,
	FechaBajaDepartamento INT DEFAULT NULL, -- Valor por defecto null, ya que cuando lo creas no puede estar de baja logica
	FechaCreacionDepartamento INT NOT NULL,
	VolumenNegocio FLOAT NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=LATIN1;

CREATE TABLE Usuario (
	CodUsuario VARCHAR(15) PRIMARY KEY,
	DescUsuario VARCHAR(250) NOT NULL,
	Password VARCHAR(64) NOT NULL,
	Perfil ENUM('administrador', 'usuario') DEFAULT 'usuario',
	FechaHoraUltimaConexion INT,
        NumConexiones int default 0
)ENGINE=INNODB DEFAULT CHARSET=LATIN1;