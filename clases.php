<?php
class DatosComunes {
    public $titulo;
    public $autor;
    public $editorial;
    public $precio;

    public function __construct($titulo, $autor, $editorial, $precio) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->editorial = $editorial;
        $this->precio = $precio;
    }
}

class Manga extends DatosComunes {
    public $volumen;
    public $ilustrador;

    public function __construct($titulo, $autor, $editorial, $precio, $volumen, $ilustrador) {
        parent::__construct($titulo, $autor, $editorial, $precio);
        $this->volumen = $volumen;
        $this->ilustrador = $ilustrador;
    }
}

class Libro extends DatosComunes {
    public $numeroPaginas;
    public $formato; //Tapa dura, digital, edicion especial, etc

    public function __construct($titulo, $autor, $editorial, $precio, $numeroPaginas, $formato) {
        parent::__construct($titulo, $autor, $editorial, $precio);
        $this->numeroPaginas = $numeroPaginas;
        $this->formato = $formato;
    }
}

class Tematica {
    public $nombre;
    public $articulos = [];

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function agregarArticulo($articulo) {
        $this->articulos[] = $articulo;
    }
}

class Biblioteca {
    public $tematicas = [];

    public function agregarTematica($tematica) {
        $this->tematicas[] = $tematica;
    }

    //Listado de todas las temáticas
    public function mostrarTematicas() {
        //Creo una lista para enumerar estéticamente
        $output = "<ul>";
        foreach ($this->tematicas as $tematica) {
            $output .= "<li>" . $tematica->nombre . "</li>";  //Selecciona el atributo a mostrar
        }
        $output .= "</ul>";
        return $output;
    }

    //Listado de cada artículo de una temática
    public function mostrarArticulosTematica($nombreTematica) {
        foreach ($this->tematicas as $tematica) {
            if ($tematica->nombre === $nombreTematica) {
                //Creo una lista para enumerar estéticamente
                $output = "<ul>";
                foreach ($tematica->articulos as $articulo) {
                    $output .= "<li>" . $articulo->titulo . " - " . $articulo->autor . "</li>"; //Selecciona los atributos a mostrar
                }
                $output .= "</ul>";
                return $output;
            }
        }
        return "Temática no encontrada.";
    }

    //Mostrar los datos de un libro
    public function mostrarDatosArticulo($titulo) {
        foreach ($this->tematicas as $tematica) {
            foreach ($tematica->articulos as $articulo) {
                if ($articulo->titulo === $titulo) {
                    //Creo una lista para enumerar estéticamente
                    $output = "<ul>";
    
                    //Selecciono los atributos a mostrar
                    $output .= "<li><strong>Título:</strong> " . $articulo->titulo . "</li>";
                    $output .= "<li><strong>Autor:</strong> " . $articulo->autor . "</li>";
                    $output .= "<li><strong>Editorial:</strong> " . $articulo->editorial . "</li>";
                    $output .= "<li><strong>Precio:</strong> " . $articulo->precio . "€</li>";
    
                    //Compruebo que tipo de articulo es para añadir sus atributos propios
                    if ($articulo instanceof Manga) {
                        $output .= "<li><strong>Volumen:</strong> " . $articulo->volumen . "</li>";
                        $output .= "<li><strong>Ilustrador:</strong> " . $articulo->ilustrador . "</li>";
                    }
                    elseif ($articulo instanceof Libro) {
                        $output .= "<li><strong>Número de Páginas:</strong> " . $articulo->numeroPaginas . "</li>";
                        $output .= "<li><strong>Formato:</strong> " . $articulo->formato . "</li>";
                    }
                    $output .= "</ul>";
                    return $output;
                }
            }
        }
        return "Artículo no encontrado.";
    }
}


//Creo los articulos
$libro1 = new Libro("El Hobbit", "J.R.R. Tolkien", "Minotauro", 20.99, 310, "Tapa dura");
$manga1 = new Manga("Naruto", "Masashi Kishimoto", "PlanetaComic", 7.99, 1, "Kasashi Mishimoto");
$libro2 = new Libro("Mistborn", "Brandon Sanderson", "Nova", 29.99, 310, "Tapa dura");
$manga2 = new Manga("Shingeki no Kyojin", "Isayama", "Norma", 8.99, 1, "Yamaisa");

//Creo las temáticas
$fantasia = new Tematica("Fantasía");
$aventura = new Tematica("Aventura");
$seinen = new Tematica("Seinen");

//Añado los articulos a las tematicas
$fantasia->agregarArticulo($libro1);
$aventura->agregarArticulo($manga1);
$fantasia->agregarArticulo($libro2);
$seinen->agregarArticulo($manga2);

//Creo la bibilioteca y le añado las tematicas
$biblioteca = new Biblioteca();
$biblioteca->agregarTematica($fantasia);
$biblioteca->agregarTematica($aventura);
$biblioteca->agregarTematica($seinen);


//Pruebo las clases para mostrar datos
print_r($biblioteca->mostrarTematicas());

print_r($biblioteca->mostrarArticulosTematica("Fantasía"));

print_r($biblioteca->mostrarArticulosTematica("Romance"));

print_r($biblioteca->mostrarDatosArticulo("Naruto"));

print_r($biblioteca->mostrarDatosArticulo("Mistborn"));
//Muestro los datos de la biblioteca
echo json_encode($biblioteca, JSON_PRETTY_PRINT);

/* 
USANDO JSON PARSER:

{
    "tematicas": [
        {
            "nombre": "Fantasía",
            "articulos": [
                {
                    "titulo": "El Hobbit",
                    "autor": "J.R.R. Tolkien",
                    "editorial": "Minotauro",
                    "precio": 20.99,
                    "numeroPaginas": 310,
                    "formato": "Tapa dura"
                },
                {
                    "titulo": "Mistborn",
                    "autor": "Brandon Sanderson",
                    "editorial": "Nova",
                    "precio": 29.99,
                    "numeroPaginas": 310,
                    "formato": "Tapa dura"
                }
            ]
        },
        {
            "nombre": "Aventura",
            "articulos": [
                {
                    "titulo": "Naruto",
                    "autor": "Masashi Kishimoto",
                    "editorial": "PlanetaComic",
                    "precio": 7.99,
                    "volumen": 1,
                    "ilustrador": "Kasashi Mishimoto"
                }
            ]
        },
        {
            "nombre": "Seinen",
            "articulos": [
                {
                    "titulo": "Shingeki no Kyojin",
                    "autor": "Isayama",
                    "editorial": "Norma",
                    "precio": 8.99,
                    "volumen": 1,
                    "ilustrador": "Yamaisa"
                }
            ]
        }
    ]
}

*/
?>