package com.example.sportify.entities.participante;

public class Participante {

    String nombre;
    int anotados;
    int puntos;
    String posicion;
    int extra;

    public int getExtra() {
        return extra;
    }

    public void setExtra(int extra) {
        this.extra = extra;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public int getAnotados() {
        return anotados;
    }

    public void setAnotados(int anotados) {
        this.anotados = anotados;
    }

    public int getPuntos() {
        return puntos;
    }

    public void setPuntos(int puntos) {
        this.puntos = puntos;
    }

    public String getPosicion() {
        return posicion;
    }

    public void setPosicion(String posicion) {
        this.posicion = posicion;
    }
}
