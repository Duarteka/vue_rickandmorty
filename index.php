<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
    <div class="contenedor">
        <h1>Api Rick and Morty</h1>
        <h2>Busca un personaje por su nombre:</h2>
        <input class="buscar" v-model="buscador" type="text"></input>
        
           <personaje v-for="item, indice in nombresFiltrados" :key="indice" :personaje="item"></personaje>
       
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
   
<script>
       Vue.component("personaje",{
           props : ["personaje"],
           template : `<div class="caracter"><div class="image"><img :src="url(personaje)"></div><p>NAME: {{personaje.name}}</p><p>GENERO: {{personaje.gender}}</p><p>ESTATUS: {{personaje.status}}</p></div>`,
            methods : {
               url(personaje){
                   return personaje.image
            }
        },
    });

        var app = new Vue({
            el : ".contenedor",
            data : {
                avatar : [],
                buscador : ''
            },
            computed : {
                nombresFiltrados(){
                   var nombres = this.avatar.filter((item)=>{
                        return item.name.toLowerCase().includes(this.buscador.toLowerCase())
                    }) 
                    //nombres.unshift(this.avatar[0])
                        
                    console.log(nombres)
                    return nombres
                }
            },
            created(){
                fetch("https://rickandmortyapi.com/api/character")
                .then(response => response.json())
                .then(json => {
                    this.avatar = json.results
                    //console.log(json)
                   
                })
            }
     
        });

 
    </script>
</body>
</html>