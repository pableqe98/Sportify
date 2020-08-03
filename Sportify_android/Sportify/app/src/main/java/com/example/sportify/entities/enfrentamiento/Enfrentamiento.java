package com.example.sportify.entities.enfrentamiento;

public class Enfrentamiento {

    int participante_1;
    int participante_2;
    int id_evento;
    String fecha;
    int puntos_1;
    int puntos_2;
    String nombre1;
    String nombre2;

    public String getNombre1() {
        return nombre1;
    }

    public void setNombre1(String nombre1) {
        this.nombre1 = nombre1;
    }

    public String getNombre2() {
        return nombre2;
    }

    public void setNombre2(String nombre2) {
        this.nombre2 = nombre2;
    }

    public int getParticipante_1() {
        return participante_1;
    }

    public void setParticipante_1(int participante_1) {
        this.participante_1 = participante_1;
    }

    public int getParticipante_2() {
        return participante_2;
    }

    public void setParticipante_2(int participante_2) {
        this.participante_2 = participante_2;
    }

    public int getId_evento() {
        return id_evento;
    }

    public void setId_evento(int id_evento) {
        this.id_evento = id_evento;
    }

    public String getFecha() {
        return fecha;
    }

    public void setFecha(String fecha) {
        this.fecha = fecha;
    }

    public int getPuntos_1() {
        return puntos_1;
    }

    public void setPuntos_1(int puntos_1) {
        this.puntos_1 = puntos_1;
    }

    public int getPuntos_2() {
        return puntos_2;
    }

    public void setPuntos_2(int puntos_2) {
        this.puntos_2 = puntos_2;
    }
}
