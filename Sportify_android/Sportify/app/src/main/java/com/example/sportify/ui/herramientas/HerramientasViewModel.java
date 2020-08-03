package com.example.sportify.ui.herramientas;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class HerramientasViewModel extends ViewModel {
    private MutableLiveData<String> mText;

    public HerramientasViewModel() {
        mText = new MutableLiveData<>();
        mText.setValue("This is herramientas fragment");
    }

    public LiveData<String> getText() {
        return mText;
    }
}