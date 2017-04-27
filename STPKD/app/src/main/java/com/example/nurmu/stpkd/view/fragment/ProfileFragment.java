package com.example.nurmu.stpkd.view.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.nurmu.stpkd.R;
import com.example.nurmu.stpkd.utility.Config;

import agency.tango.android.avatarview.IImageLoader;
import agency.tango.android.avatarview.loader.PicassoLoader;
import agency.tango.android.avatarview.views.AvatarView;

/**
 * Created by nurmu on 05/26/2017.
 */

public class ProfileFragment extends Fragment {


    private AvatarView avatarWithNoImageSmall;
    private IImageLoader imageLoader;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_profile, container, false);

        TextView txtIDTPS = (TextView) view.findViewById(R.id.txtIDTPS);
        TextView txtNamaLengkap = (TextView) view.findViewById(R.id.txtNamaLengkap);
        TextView txtAlamat = (TextView) view.findViewById(R.id.txtAlamat);
        TextView txtNoHP = (TextView) view.findViewById(R.id.txtNoHP);
        TextView txtEmail = (TextView) view.findViewById(R.id.txtEmail);

        txtIDTPS.setText(Config.surveyor.getSurveyor_pilkada_tps_id());
        txtNamaLengkap.setText(Config.surveyor.getSurveyor_fullname());
        txtAlamat.setText(Config.surveyor.getSurveyor_address());
        txtNoHP.setText(Config.surveyor.getSurveyor_phone());
        txtEmail.setText(Config.surveyor.getSurveyor_email());

        avatarWithNoImageSmall = (AvatarView) view.findViewById(R.id.imgMenuUser);
        loadAvatarData();

        return view;
    }

    private void loadAvatarData() {
        imageLoader = new PicassoLoader();
        imageLoader.loadImage(avatarWithNoImageSmall, Config.baseURL + "/" + Config.surveyor.getSurveyor_photo(), Config.surveyor.getSurveyor_username());
    }
}
