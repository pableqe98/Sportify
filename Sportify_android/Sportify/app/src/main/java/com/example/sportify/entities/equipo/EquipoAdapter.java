package com.example.sportify.entities.equipo;

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

public class EquipoAdapter extends BaseAdapter {

    protected Context context;
    protected List<Equipo> items;

    public EquipoAdapter(final Context context,final List<Equipo> items) {
        this.context = context;
        this.items = items;
    }

    public void clear(){
        items.clear();
    }

    public void addAll(List<Equipo> equipos){
        items.clear();
        for(int i=0 ; i < equipos.size() ; i++)
            items.add(equipos.get(i));
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

    public List<Equipo> getItems() {
        return items;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        EquipoAdapter.ViewHolderEquipo viewHolder;

        if(convertView == null){
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(R.layout.equipo_item,parent,false);

            viewHolder = new EquipoAdapter.ViewHolderEquipo();
            viewHolder.id_equipo = (TextView) convertView.findViewById(R.id.id_equipo);
            viewHolder.nombre_equipo = (TextView) convertView.findViewById(R.id.nombre_equipo);
            viewHolder.logo_equipo = (ImageView) convertView.findViewById(R.id.image_equipo);


            convertView.setTag(viewHolder);
        }
        else{
            viewHolder = (EquipoAdapter.ViewHolderEquipo) convertView.getTag();
        }

        Equipo obj = items.get(position);

        if(items != null){
            viewHolder.id_equipo.setText(Integer.toString(obj.getId_equipo()));
            viewHolder.nombre_equipo.setText(obj.getNombre_equipo());

            Picasso.get().load("http://192.168.0.52/sportify/public/"+obj.getLogo_equipo()).into(viewHolder.logo_equipo);


        }

        return convertView;

    }

    static class ViewHolderEquipo{
        TextView id_equipo;
        TextView nombre_equipo;
        ImageView logo_equipo;

    }

}
