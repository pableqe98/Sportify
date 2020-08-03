package com.example.sportify.entities.eventos;

import com.example.sportify.entities.enfrentamiento.Enfrentamiento;
import com.example.sportify.entities.enfrentamiento.ListaEnfrentamiento;
import com.example.sportify.entities.equipo.Equipo;
import com.example.sportify.entities.equipo.ListaEquipos;
import com.example.sportify.entities.participante.ListaParticipantes;
import com.example.sportify.entities.participante.Participante;

import java.util.List;

public class ConsultaEvento {

    List<Enfrentamiento> enfrentamientos;
    String empezado;
    String acabado;
    String apuntado;
    List<Equipo> equipos;
    List<Participante> participantes;
    String tipo_participante;

    public void setEnfrentamientos(List<Enfrentamiento> enfrentamientos) {
        this.enfrentamientos = enfrentamientos;
    }

    public void setEmpezado(String empezado) {
        this.empezado = empezado;
    }

    public void setAcabado(String acabado) {
        this.acabado = acabado;
    }

    public void setApuntado(String apuntado) {
        this.apuntado = apuntado;
    }

    public void setEquipos(List<Equipo> equipos) {
        this.equipos = equipos;
    }

    public void setParticipantes(List<Participante> participantes) {
        this.participantes = participantes;
    }

    public void setTipo_participante(String tipo_participante) {
        this.tipo_participante = tipo_participante;
    }

    public List<Enfrentamiento> getEnfrentamientos() {
        return enfrentamientos;
    }

    public String getEmpezado() {
        return empezado;
    }

    public String getAcabado() {
        return acabado;
    }

    public String getApuntado() {
        return apuntado;
    }

    public List<Equipo> getEquipos() {
        return equipos;
    }

    public List<Participante> getParticipantes() {
        return participantes;
    }

    public String getTipo_participante() {
        return tipo_participante;
    }
}
