#!/bin/bash

# Criar estrutura de pastas
mkdir -p public/css/base
mkdir -p public/css/components
mkdir -p public/css/layout
mkdir -p public/css/pages
mkdir -p public/css/themes

# Criar arquivos base
echo "* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Open Sans', sans-serif;
}" > public/css/base/reset.css

echo "h1, h2, h3 {
    font-family: 'Open Sans', \"Helvetica Neue\", Helvetica, Arial, sans-serif;
}

.span-subtitulo-marinha {
    font-size: 14px;
    font-weight: 400;
    font-family: 'Open Sans', sans-serif;
}

.span-subtitulo-lema {
    font-size: 13px;
    font-weight: 400;
}" > public/css/base/typography.css

# Criar arquivos de componentes
echo "button {
    background-color: #4682B4;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; 
}

button:hover {
    background-color: #0db60d; 
    transform: translateY(-2px); 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
}

.custom-button {
    display: inline-block;
    padding: 10px 20px;
    border: 1px solid #4b8cfb;
    border-radius: 5px;
    background-color: #4b8cfb;
    color: white;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}

.custom-button:hover {
    background-color: #2e6cd1;
    border-color: #2e6cd1;
}" > public/css/components/buttons.css

echo ".form-input {
    background: #e3e3e3;
    padding: 10px 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 100%;
    margin-bottom: 1rem;
    padding-left: 30px;
}

.input-icon-wrapper {
    position: relative;
    min-height: 50px;
}

.input-icon-wrapper i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    z-index: 10;
}

.custom-file-upload {
    cursor: pointer;
    position: relative;
    overflow: hidden;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 6px 12px;
    background-color: #f9f9f9;
    color: #333;
    transition: box-shadow 0.3s ease;
}" > public/css/components/forms.css

# Criar arquivos de layout
echo "header {
    background-color: #2160bd;
    align-items: center;
    width: 100%; 
    z-index: 1000; 
    top: 0; 
    position: fixed;
    height: 146px;
}

.brasao-container {
    display: flex;
    align-items: center;
    width: 100%;
    color: white;
}

header img {
    margin-right: 10px;
    height: 70px;
    margin-top: 15px;
}

.titulo-container {
    display: flex;
    flex-direction: column;
}" > public/css/layout/header.css

echo "footer {
    background-color: #f0f0f0;
    padding: 10px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%;
}" > public/css/layout/footer.css

# Criar arquivos de páginas
echo ".login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(to bottom, #ffffff, #f0f0f0);
}

.login-box {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.login-box h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}

.login-btn {
    width: 100%;
    padding: 10px;
    background: linear-gradient(to bottom, #0f74ea, #2f7ab7);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}" > public/css/pages/login.css

echo ".main-container {
    display: flex;
    flex-direction: column;
    background: #ffffff; 
    border: 1px solid #d7d7d7; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    border-radius: 10px; 
    padding: 30px; 
    width: 80%;
    max-width: 500px; 
    margin: 50px auto; 
}

#jqxgrid {
    margin-top: 20px;
    margin-bottom: 50px;
    overflow-y: auto;
}" > public/css/pages/consulta.css

# Criar arquivo de tema
echo ":root {
    --primary-color: #2160bd;
    --secondary-color: #0f74ea;
    --background-color: #f0f0f0;
    --text-color: #333;
}" > public/css/themes/default-theme.css

# Criar global.css
echo "@import 'base/reset.css';
@import 'base/typography.css';
@import 'themes/default-theme.css';

@import 'layout/header.css';
@import 'layout/footer.css';

@import 'components/buttons.css';
@import 'components/forms.css';

@import 'pages/login.css';
@import 'pages/consulta.css';" > public/css/global.css

echo "Estrutura de CSS criada com sucesso!"
