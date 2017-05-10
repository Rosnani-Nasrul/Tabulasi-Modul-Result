package com.example.nurmu.stpkd.view.activity;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nurmu.stpkd.R;
import com.example.nurmu.stpkd.model.Surveyor;
import com.example.nurmu.stpkd.utility.Config;
import com.example.nurmu.stpkd.view.fragment.GrafikFragment;
import com.example.nurmu.stpkd.view.fragment.HelpFragment;
import com.example.nurmu.stpkd.view.fragment.HomeFragment;
import com.example.nurmu.stpkd.view.fragment.InfoFragment;
import com.example.nurmu.stpkd.view.fragment.ProfileFragment;
import com.example.nurmu.stpkd.view.fragment.ResultHasilFragment;
import com.example.nurmu.stpkd.view.fragment.ResultInputFragment;
import com.onurciner.webserviceconnect.MethodType;
import com.onurciner.webserviceconnect.WebServiceGetData;
import com.onurciner.webserviceconnect.WebServiceSendData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import agency.tango.android.avatarview.IImageLoader;
import agency.tango.android.avatarview.loader.PicassoLoader;
import agency.tango.android.avatarview.views.AvatarView;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    private Toolbar toolbar;
    private AvatarView avatarWithNoImageSmall;
    private IImageLoader imageLoader;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        changeFragment(new HomeFragment());
//        init();

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        View mnView = navigationView.getHeaderView(0);
        TextView nav_user = (TextView) mnView.findViewById(R.id.txtMenuUser);
        nav_user.setText(Config.surveyor.getSurveyor_fullname());
        TextView nav_email = (TextView) mnView.findViewById(R.id.txtMenuEmail);
        nav_email.setText(Config.surveyor.getSurveyor_email());


        avatarWithNoImageSmall = (AvatarView) mnView.findViewById(R.id.imgMenuUser);
        loadAvatarData();

    }

    private void loadAvatarData() {
        imageLoader = new PicassoLoader();
        imageLoader.loadImage(avatarWithNoImageSmall, Config.baseURL + "/" + Config.surveyor.getSurveyor_photo(), Config.surveyor.getSurveyor_username());
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);

        Fragment view = null;

        if (id == R.id.home) {
            view = new HomeFragment();
            toolbar.setTitle("Home");
        } else if (id == R.id.profile) {
            view = new ProfileFragment();
            toolbar.setTitle("Profile");
        } else if (id == R.id.result) {
            result();
            return true;
        } else if (id == R.id.grafik) {
            view = new GrafikFragment();
            toolbar.setTitle("Grafik");
        } else if (id == R.id.info) {
            view = new InfoFragment();
            toolbar.setTitle("Info");
        } else if (id == R.id.help) {
            view = new HelpFragment();
            toolbar.setTitle("Help");
        } else if (id == R.id.logout) {
            changeActivity(this, LoginActivity.class, true);
            return true;
        }
        changeFragment(view);

        return true;
    }

    public void changeActivity(Activity source, Class<?> destination, Boolean shouldFinishContext) {
        if (shouldFinishContext) {
            source.finish();
        }
        Intent intent = new Intent(source, destination);
        source.startActivity(intent);
    }


    public void changeFragment(Fragment view) {
        FragmentManager manager = getFragmentManager();
        FragmentTransaction transaction = manager.beginTransaction();
        transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_FADE);
        transaction.replace(R.id.container, view);
        transaction.commit();
    }

    public void result() {
        try {
            String result = (String) new WebServiceSendData()
                    .setUrl(Config.baseURL + "/user/get_result")
                    .setData("id_user=" + Config.surveyor.getSurveyor_id())
                    .setRequestMethod(MethodType.POST)
                    .connect();

            Log.d("JSON GET", result);
            JSONObject dataAsliService = new JSONObject(result);
            if (dataAsliService != null) {
                JSONArray data = dataAsliService.getJSONArray("data");
                int status = dataAsliService.getInt("status");

                if (status == 1) {
                    Fragment view = new ResultHasilFragment();
                    toolbar.setTitle("Result");
                    changeFragment(view);
                } else {
                    Fragment view = new ResultInputFragment();
                    toolbar.setTitle("Input Result");
                    changeFragment(view);
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public void init() {
        try {
            String result = (String) new WebServiceSendData()
                    .setUrl(Config.baseURL + "/user/login")
                    .setData("username=karyawan&password=karyawan")
                    .setRequestMethod(MethodType.POST)
                    .connect();

            Log.d("JSON GET", result);
            JSONObject dataAsliService = new JSONObject(result);
            if (dataAsliService != null) {
                JSONArray data = dataAsliService.getJSONArray("data");
                int status = dataAsliService.getInt("status");

                if (status == 1) {
                    JSONObject user = data.getJSONObject(0);

                    String surveyor_id = user.getString("surveyor_id");
                    String surveyor_pilkada_tps_id = user.getString("surveyor_pilkada_tps_id");
                    String surveyor_nip = user.getString("surveyor_nip");
                    String surveyor_username = user.getString("surveyor_username");
                    String surveyor_password = user.getString("surveyor_password");
                    String surveyor_address = user.getString("surveyor_address");
                    String surveyor_photo = user.getString("surveyor_photo");
                    String surveyor_phone = user.getString("surveyor_phone");
                    String surveyor_email = user.getString("surveyor_email");
                    String surveyor_create_by = user.getString("surveyor_create_by");
                    String surveyor_create_date = user.getString("surveyor_create_date");
                    String surveyor_status = user.getString("surveyor_status");
                    String surveyor_log_code = user.getString("surveyor_log_code");
                    String surveyor_fullname = user.getString("surveyor_fullname");

                    Surveyor surveyorObj = new Surveyor(surveyor_id, surveyor_pilkada_tps_id, surveyor_nip, surveyor_fullname, surveyor_username, surveyor_password, surveyor_address, surveyor_photo, surveyor_phone, surveyor_email, surveyor_create_by, surveyor_create_date, surveyor_status, surveyor_log_code);
                    Config.surveyor = surveyorObj;
                } else {
                    Toast.makeText(getApplicationContext(), "Username atau password salah", Toast.LENGTH_SHORT).show();
                }
            }

        } catch (IOException e) {
            e.printStackTrace();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
