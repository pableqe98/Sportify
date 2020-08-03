package com.example.sportify.entities.chats;

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

public class MensajeAdapter extends BaseAdapter {

    protected Context context;
    protected List<MensajeChat> items;

    public MensajeAdapter(final Context context,final List<MensajeChat> items) {
        this.context = context;
        this.items = items;
    }

    public void clear(){
        items.clear();
    }

    public void addAll(List<MensajeChat> chats){
        items.clear();
        for(int i=0 ; i < chats.size() ; i++)
            items.add(chats.get(i));
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
    public List<MensajeChat> getItems() {
        return items;
    }

    @Override
    public View getView(int i, View convertView, ViewGroup parent) {
        ViewHolderMensaje viewHolder;

        if(convertView == null){
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(R.layout.mensaje_item,parent,false);

            viewHolder = new ViewHolderMensaje();
            viewHolder.id_mensaje = (TextView)convertView.findViewById(R.id.tx_id_mensaje);
            viewHolder.fecha_m = (TextView)convertView.findViewById(R.id.tx_fecha);
            viewHolder.hora_m = (TextView)convertView.findViewById(R.id.tx_hora);
            viewHolder.contenido_m = (TextView)convertView.findViewById(R.id.tx_contenido);
            viewHolder.nombre_emisor = (TextView)convertView.findViewById(R.id.tx_nombre_usuario);
            viewHolder.foto_usuario = (ImageView) convertView.findViewById(R.id.img_mensaje);

            convertView.setTag(viewHolder);
        }
        else{
            viewHolder = (ViewHolderMensaje) convertView.getTag();
        }

        MensajeChat obj = items.get(i);

        if(items != null){
            viewHolder.id_mensaje.setText(Integer.toString(obj.getId_mensaje()));
            viewHolder.fecha_m.setText(obj.getFecha_m());
            viewHolder.hora_m.setText(obj.getHora_m());
            viewHolder.contenido_m.setText(obj.getContenido_m());
            viewHolder.nombre_emisor.setText(obj.getNombre_emisor());

            Picasso.get().load("http://192.168.0.52/sportify/public/"+obj.getFoto_usuario()).resize(77, 59).centerCrop().into(viewHolder.foto_usuario);

        }

        return convertView;

    }

    static class ViewHolderMensaje{
        TextView id_mensaje;
        TextView fecha_m;
        TextView hora_m;
        TextView contenido_m;
        TextView nombre_emisor;
        ImageView foto_usuario;

    }
}
