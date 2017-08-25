package com.myruns.Reloj;
import jssc.SerialPortException;
import org.xml.sax.SAXException;

import javax.xml.transform.TransformerException;
import java.io.IOException;

/**
 * Created by Larraitz on 06/07/2017.
 */
public class GPS {

    public static void main(String[] args) {
        lora l = new lora("COM3");
//        l.crearXML();
//
//        while (true)
//        {
//            try {
//                l.escribirCoordenadasXMLPrueba();
//                Thread.sleep(500);
//            } catch (IOException e) {
//                e.printStackTrace();
//            } catch (SAXException e) {
//                e.printStackTrace();
//            } catch (TransformerException e) {
//                e.printStackTrace();
//            } catch (InterruptedException e) {
//                e.printStackTrace();
//            }
//        }

        try {
            l.iniciar();
            l.crearXML();
            while (true)
            {
                l.coordenadas();
            }
        } catch (SerialPortException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (SAXException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } catch (TransformerException e) {
            e.printStackTrace();
        }
    }
}
