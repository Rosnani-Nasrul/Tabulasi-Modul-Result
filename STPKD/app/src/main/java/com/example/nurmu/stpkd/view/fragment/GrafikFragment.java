package com.example.nurmu.stpkd.view.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.nurmu.stpkd.model.Surveyor;
import com.example.nurmu.stpkd.utility.Config;
import com.github.mikephil.charting.charts.BarChart;
import com.github.mikephil.charting.components.XAxis;
import com.github.mikephil.charting.components.XAxis.XAxisPosition;
import com.github.mikephil.charting.data.BarData;
import com.github.mikephil.charting.data.BarDataSet;
import com.github.mikephil.charting.data.BarEntry;
import com.github.mikephil.charting.formatter.IndexAxisValueFormatter;
import com.github.mikephil.charting.interfaces.datasets.IBarDataSet;
import com.github.mikephil.charting.utils.ColorTemplate;

import com.example.nurmu.stpkd.R;
import com.onurciner.webserviceconnect.MethodType;
import com.onurciner.webserviceconnect.WebServiceSendData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;

/**
 * Created by nurmu on 05/26/2017.
 */

public class GrafikFragment extends Fragment {

    protected BarChart mChart;
    View view;

    public void init() {
        try {
            String result = (String) new WebServiceSendData()
                    .setUrl(Config.baseURL + "/user/get_grafik")
                    .setData("id_user=" + Config.surveyor.getSurveyor_id())
                    .setRequestMethod(MethodType.POST)
                    .connect();

            Log.d("JSON GET", result);
            JSONObject dataAsliService = new JSONObject(result);
            if (dataAsliService != null) {
                JSONArray data = dataAsliService.getJSONArray("data");
                ArrayList<BarEntry> yVals1 = new ArrayList<>();
                String kandidatList[] = new String[data.length()];

                for (int i = 0; i < data.length(); i++) {
                    JSONObject data_kandidat = data.getJSONObject(i);
                    kandidatList[i] = data_kandidat.getString("pilkada_candidate_name");
                    yVals1.add(new BarEntry(i, data_kandidat.getInt("jumlah")));
                }

                BarDataSet set1;
                set1 = new BarDataSet(yVals1, "Result Pilkada");

                set1.setDrawIcons(false);

                set1.setColors(ColorTemplate.MATERIAL_COLORS);

                ArrayList<IBarDataSet> dataSets = new ArrayList<IBarDataSet>();
                dataSets.add(set1);

                BarData dataBar = new BarData(dataSets);
                dataBar.setValueTextSize(10f);
                dataBar.setBarWidth(0.9f);

                mChart.setData(dataBar);
                XAxis xAxis = mChart.getXAxis();
                xAxis.setPosition(XAxisPosition.BOTTOM);
                xAxis.setDrawGridLines(false);
                xAxis.setGranularity(1f);
                xAxis.setLabelCount(7);
                xAxis.setValueFormatter(new IndexAxisValueFormatter(kandidatList));

            }

        } catch (IOException e) {
            e.printStackTrace();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_grafik, container, false);

        mChart = (BarChart) view.findViewById(R.id.barChart1);
        init();

        return view;
    }
}
