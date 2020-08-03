package com.example.sportify.entities.eventos;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.sportify.R;
import com.squareup.picasso.Picasso;

import java.util.List;

public class EventoAdapter extends BaseAdapter {

    protected Context context;
    protected List<Evento> items;

    public EventoAdapter(final Context context,final List<Evento> items) {
        this.context = context;
        this.items = items;
    }

    public void clear(){
        items.clear();
    }

    public void addAll(List<Evento> eventos){
        items.clear();
        for(int i=0 ; i < eventos.size() ; i++)
            items.add(eventos.get(i));
    }

    @Override
    public int getCount() {
        return items.size();
    }

    @Override
    public Object getItem(int i) {
        return items.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    public List<Evento> getItems() {
        return items;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        ViewHolder viewHolder;

        if(convertView == null){
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(R.layout.evento_item,parent,false);

            viewHolder = new ViewHolder();
            viewHolder.id_evento = (TextView)convertView.findViewById(R.id.id_evento);
            viewHolder.titulo_evento = (TextView) convertView.findViewById(R.id.titulo_e);
            viewHolder.foto = (ImageView) convertView.findViewById(R.id.image_evento);
            viewHolder.tematica = (TextView) convertView.findViewById(R.id.tematica);

            convertView.setTag(viewHolder);
        }
        else{
            viewHolder = (ViewHolder) convertView.getTag();
        }

        Evento obj = items.get(position);

        if(items != null){
            viewHolder.id_evento.setText(Integer.toString(obj.getId_evento()));
            viewHolder.titulo_evento.setText(obj.getTitulo_e());
            viewHolder.tematica.setText(obj.getTematica());

            Picasso.get().load("http://192.168.0.52/sportify/public/"+obj.getFoto()).into(viewHolder.foto);


        }

        return convertView;

    }

    static class ViewHolder{
        TextView id_evento;
        TextView titulo_evento;
        ImageView foto;
        TextView tematica;

    }


}


