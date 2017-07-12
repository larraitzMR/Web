package com.myruns.Reloj;

import jssc.*;
import java.io.*;

import org.w3c.dom.*;
import org.xml.sax.SAXException;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.transform.*;

/**
 * Created by Larraitz on 06/07/2017.
 */
public class lora {

    private String port;
    private SerialPort serialPort;

    String parsing;
    String hora;
    String lat;
    String latC;
    String longi;
    String longiC;
    String horayCoord;

    public lora(String port){
        this.port = port;
        serialPort = new SerialPort(port);
    }

    public void iniciar() throws SerialPortException, InterruptedException  {
//        String[] portNames = SerialPortList.getPortNames();
//        serialPort = new SerialPort("COM8");
        try {
            serialPort.openPort();
            serialPort.setParams(SerialPort.BAUDRATE_115200,
                    SerialPort.DATABITS_8,
                    SerialPort.STOPBITS_1,
                    SerialPort.PARITY_NONE);
        }
        catch (SerialPortException ex) {
            System.out.println("No se puede abrir el puerto: " + ex);
        }
    }

    String original = "GPS 00:00:00 00 00 00.0 0 00 00 00.0";
    public void coordenadas() throws SerialPortException, TransformerException, SAXException, IOException {

        try {
            parsing = serialPort.readString();
            while  (parsing == null)
            {
                parsing = serialPort.readString();
                Thread.sleep(100);
            }
//            System.out.println(parsing);
        } catch (SerialPortException ex) {
            System.out.println("There are an error on writing string to port т: " + ex);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
        if (parsing == null)
        {
//            System.out.println("No se ha recibido nada del GPS");
            return;
        }
        else {
//            if (parsing.contains("GPS"))
//            {
            int contador = 0;
            int intIndex = 0;
            String gps = "";
            String coord = parsing;
            String buscar = "GPS";
            while (coord.indexOf(buscar) > -1) {
                intIndex = coord.indexOf(buscar);
                coord = coord.substring(coord.indexOf(buscar)+buscar.length(),coord.length());
                contador++;
            }
            if(coord.length() > original.length()){
                gps = coord.substring(0, 35);
            }
            else {
                return;
            }
//
            System.out.println(gps);
            hora =  gps.substring(1, 9);
            lat =  gps.substring(10, 20);
            latC =  gps.substring(21, 22);
            longi =  gps.substring(23, 33);
            longiC =  gps.substring(34, 35);
            horayCoord = String.format("%s %s %s %s %s\r\n", hora,lat,latC, longi,longiC);
            escribirCoordenadas();
            escribirCoordenadasXML(hora, lat+ " " + latC, longi+ " " + longiC);
//            }
//            else{
//                System.out.println("No han llegado las coordenadas");
//            }
        }
    }

    Document document = null;
    String nombreDoc = "C:\\Users\\Propietario\\Documents\\GitHub\\Web\\coordenadasGPS.xml";
    //    String nombreDoc = "Coordenadas.xml";
    public void crearXML()
    {
        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
        try{
            DocumentBuilder builder = factory.newDocumentBuilder();
            DOMImplementation implementation = builder.getDOMImplementation();
            document = implementation.createDocument(null, "xml", null);
            document.setXmlVersion("1.0");

            Source source = new DOMSource(document);
            Result result = new StreamResult(new java.io.File(nombreDoc));
            Transformer transformer = TransformerFactory.newInstance().newTransformer();
            transformer.setOutputProperty(OutputKeys.INDENT, "yes");
            transformer.setOutputProperty("{http://xml.apache.org/xslt}indent-amount", "2");
            transformer.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "no");

            transformer.transform(source, result);

            //initialize StreamResult with File object to save to file
//            StreamResult resultado= new StreamResult(new StringWriter());
//            DOMSource init = new DOMSource(document);
//            transformer.transform(init, resultado);
//            String xmlString = resultado.getWriter().toString();
////            System.out.println(xmlString);


        }catch(Exception e){
            System.err.println("Error");
        }
    }

    public void escribirCoordenadasXML(String horaRec, String latRec, String lonRec) throws IOException, SAXException, TransformerException {
        try {
            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
            DocumentBuilder db = null;
            db = dbf.newDocumentBuilder();
            document = db.parse(new File(nombreDoc));
            document.getDocumentElement().normalize();

            Element gps = document.createElement("GPS");
            Element hora= document.createElement("Hora");
            Element latitud = document.createElement("Latitud");
            Element longitud = document.createElement("Longitud");

            document.getDocumentElement().appendChild(gps);

            gps.appendChild(hora);
            hora.appendChild(document.createTextNode(horaRec));
            gps.appendChild(latitud);
            latitud.appendChild(document.createTextNode(latRec));
            gps.appendChild(longitud);
            longitud.appendChild(document.createTextNode(lonRec));

            Source source = new DOMSource(document);
            Result result = new StreamResult(new java.io.File(nombreDoc));
            Transformer transformer = TransformerFactory.newInstance().newTransformer();
            transformer.setOutputProperty(OutputKeys.INDENT, "yes");
            transformer.setOutputProperty("{http://xml.apache.org/xslt}indent-amount", "2");
            transformer.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "no");
            transformer.transform(source, result);

            //initialize StreamResult with File object to save to file
            StreamResult resultado= new StreamResult(new StringWriter());
            DOMSource init = new DOMSource(document);
            transformer.transform(init, resultado);
            String xmlString = resultado.getWriter().toString();
//            System.out.println(xmlString);

        } catch (ParserConfigurationException e) {
            e.printStackTrace();
        }

    }

    String horaP;
    String latP;
    String lonP;
    int segundos = 10;
    int segundosGradoslat = 30;
    int segundosGradoslon = 10;
    int milisegundosGrados = 0;

    public void escribirCoordenadasXMLPrueba() throws IOException, SAXException, TransformerException {
        try {
            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
            DocumentBuilder db = null;
            db = dbf.newDocumentBuilder();
            document = db.parse(new File(nombreDoc));
            document.getDocumentElement().normalize();

            Element gps = document.createElement("GPS");
            Element hora= document.createElement("Hora");
            Element latitud = document.createElement("Latitud");
            Element longitud = document.createElement("Longitud");

            document.getDocumentElement().appendChild(gps);

            horaP = "11:55:" + segundos;
            latP = "43 17 " + segundosGradoslat + "." + milisegundosGrados;
            lonP = "01 59 " + segundosGradoslon + "." + milisegundosGrados;

            milisegundosGrados++;

            if (milisegundosGrados == 10)
            {
                milisegundosGrados = 0;
                segundosGradoslat++;
                segundosGradoslon++;
            }
            gps.appendChild(hora);
            hora.appendChild(document.createTextNode(horaP));
            gps.appendChild(latitud);
            latitud.appendChild(document.createTextNode(latP));
            gps.appendChild(longitud);
            longitud.appendChild(document.createTextNode(lonP));

            Source source = new DOMSource(document);
            Result result = new StreamResult(new java.io.File(nombreDoc));
            Transformer transformer = TransformerFactory.newInstance().newTransformer();
            transformer.setOutputProperty(OutputKeys.INDENT, "yes");
            transformer.setOutputProperty("{http://xml.apache.org/xslt}indent-amount", "2");
            transformer.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "no");
            transformer.transform(source, result);

            //initialize StreamResult with File object to save to file
            StreamResult resultado= new StreamResult(new StringWriter());
            DOMSource init = new DOMSource(document);
            transformer.transform(init, resultado);
            String xmlString = resultado.getWriter().toString();
//            System.out.println(xmlString);

        } catch (ParserConfigurationException e) {
            e.printStackTrace();
        }

    }

    public void escribirCoordenadas()
    {
        FileWriter fichero = null;
        PrintWriter pw = null;
        try
        {
            File TextFile = new File("C:\\Users\\Propietario\\Documents\\GitHub\\Web\\coordenadas.txt");
            fichero = new FileWriter(TextFile,true);
//            pw = new PrintWriter(fichero);
            fichero.write(horayCoord);
//            fichero.println("\r\n");
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                // Nuevamente aprovechamos el finally para
                // asegurarnos que se cierra el fichero.
                if (null != fichero)
                    fichero.close();
            } catch (Exception e2) {
                e2.printStackTrace();
            }
        }
    }



}
