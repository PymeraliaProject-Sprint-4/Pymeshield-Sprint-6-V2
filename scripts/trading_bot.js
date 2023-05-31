//Utilitzem la llibreria express, per a permitir que altres programes interactuen amb el bot
const express = require('express');
//Utilitzem la llibreria axios, per a fer peticions a les APIs
const axios = require('axios');
/*Utilitzem la llibreria RandomForest per entrenar i utilitzar un model basat en l algorisme Random Forest 
per resoldre problemes de classificació.*/
const { RandomForestClassifier } = require('ml-random-forest');
//Utilitzem la biblioteca talib-binding, per al anàlisi tècnic en finançes.
const talib = require('talib-binding');
/*Utilitzem la llibreria de tronWeb, per a obtenir la nostra billetera, 
per guardar les ganàncies del bot acomulades durant el temps escollit */
const TronWeb = require('tronweb');
/*Utilitzem la llibreria fs, per a poder crear un arxiu JSON que serà l'estat del bot quan tanque una operació, 
amb la quantitat que porta emmagatzemada */
const fs = require('fs');
//Utilitzem la llibreria path,per a construir les rutes que necessitèsem
const path = require('path');
//Utilitzem la llibreria util amb la funcio promisify, per a traballar amb funcions asincrones
const { promisify } = require('util');

const app = express();
app.use(express.json());

// Diccionario para almacenar los usuarios y sus datos
const users = {};

// Configurar TronWeb
const tronWeb = new TronWeb({
  fullHost: 'https://api.trongrid.io',
});

// Función para obtener los datos históricos de velas de un par de criptomonedas desde la API de Binance
async function getHistoricalData(symbol, interval, limit) {
  try {
    const response = await axios.get(`https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=${interval}&limit=${limit}`);
    return response.data;
  } catch (error) {
    console.error('Error al obtener los datos históricos:', error);
    throw error;
  }
}

// Función para realizar operaciones de compra en un par de criptomonedas
async function performBuyOrder(user, symbol, usdtAmount, riskLimit) {
  try {
    // Obtener el precio actual de la criptomoneda
    const currentPrice = await getPrice(symbol);
    const quantity = usdtAmount / currentPrice;

    // Calcular el beneficio y acumularlo en el estado del bot del usuario
    const profit = -quantity;
    accumulateProfit(user, profit);

    // Establecer límite de riesgo máximo y órdenes de stop-loss
    const riskThreshold = usdtAmount * riskLimit;
    const stopLossPrice = currentPrice - (currentPrice * riskLimit);

    // Mostrar información en la terminal de seguimiento
    console.log(`Compra exitosa: se compró ${quantity} ${symbol}`);
    console.log(`Límite de riesgo máximo: ${riskThreshold}`);
    console.log(`Precio de stop-loss: ${stopLossPrice}`);

    // Realizar monitoreo constante
    setInterval(async () => {
      const updatedPrice = await getPrice(symbol);

      // Actualizar órdenes de stop-loss si es necesario
      if (updatedPrice < stopLossPrice) {
        console.log(`Stop-loss alcanzado: vender ${quantity} ${symbol}`);
        await performSellOrder(user, symbol, usdtAmount);
        clearInterval(interval);
      } else {
        console.log(`Precio actual de ${symbol}: ${updatedPrice}`);
      }
    }, 1000); // Intervalo de monitoreo en milisegundos

  } catch (error) {
    console.error(`Error en la operación de compra: ${error}`);
  }
}

// Función para realizar operaciones de venta en un par de criptomonedas
async function performSellOrder(user, symbol, usdtAmount, profitLimit, lossLimit) {
  try {
    // Obtener el precio actual de la criptomoneda
    const currentPrice = await getPrice(symbol);
    const quantity = usdtAmount / currentPrice;

    // Calcular el beneficio y acumularlo en el estado del bot del usuario
    const profit = quantity;
    accumulateProfit(user, profit);

    // Establecer límite de ganancias y pérdidas
    const targetProfit = usdtAmount * profitLimit;
    const targetLoss = usdtAmount * lossLimit;

    // Calcular precios objetivo
    const targetProfitPrice = currentPrice + (currentPrice * profitLimit);
    const targetLossPrice = currentPrice - (currentPrice * lossLimit);

    // Implementar órdenes de stop-loss y trailing stops
    const stopLossPrice = targetLossPrice;
    const trailingStopPrice = targetProfitPrice;

    // Mostrar información en la terminal de seguimiento
    console.log(`Venta exitosa: se vendió ${quantity} ${symbol}`);
    console.log(`Límite de ganancias: ${targetProfit}`);
    console.log(`Límite de pérdidas: ${targetLoss}`);
    console.log(`Precio objetivo de ganancias: ${targetProfitPrice}`);
    console.log(`Precio objetivo de pérdidas: ${targetLossPrice}`);
    console.log(`Precio de stop-loss: ${stopLossPrice}`);
    console.log(`Precio de trailing stop: ${trailingStopPrice}`);

    // Realizar monitoreo constante
    setInterval(async () => {
      const updatedPrice = await getPrice(symbol);

      // Actualizar órdenes de stop-loss y trailing stops si es necesario
      if (updatedPrice >= trailingStopPrice) {
        trailingStopPrice = updatedPrice + (updatedPrice * profitLimit);
      }
      if (updatedPrice <= stopLossPrice) {
        console.log(`Stop-loss alcanzado: vender ${quantity} ${symbol}`);
        await executeSellOrder(user, symbol, usdtAmount);
        clearInterval(interval);
      } else if (updatedPrice >= trailingStopPrice) {
        console.log(`Trailing stop activado: vender ${quantity} ${symbol}`);
        await executeSellOrder(user, symbol, usdtAmount);
        clearInterval(interval);
      } else {
        console.log(`Precio actual de ${symbol}: ${updatedPrice}`);
      }
    }, 1000); // Intervalo de monitoreo en milisegundos

  } catch (error) {
    console.error(`Error en la operación de venta: ${error}`);
  }
}

// Función para actualizar la billetera Tron del usuario con las ganancias acumuladas
async function updateTronWallet(user, totalProfit) {
  try {
    // Obtener la dirección, clave privada y clave pública de la billetera Tron del usuario
    const walletAddress = user.walletAddress;
    const privateKey = user.privateKey;
    const publicKey = user.publicKey;

    // Crear una instancia de TronWeb utilizando la clave privada y el proveedor
    const tronWeb = new TronWeb({
      fullHost: 'https://api.trongrid.io',
      privateKey: privateKey
    });

    // Lógica para actualizar la billetera Tron del usuario con las ganancias
    const updatedBalance = user.capital + totalProfit;

    //Actualizar la billetera Tron utilizando TronWeb
    await tronWeb.trx.sendTransaction(walletAddress, updatedBalance);

  } catch (error) {
    console.error(`Error al actualizar la billetera Tron del usuario ${user.id}: ${error}`);
  }
}

// Función para obtener el precio actual de un par de criptomonedas
async function getPrice(symbol) {
  try {
    const response = await axios.get(`https://api.binance.com/api/v3/ticker/price?symbol=${symbol}`);
    return parseFloat(response.data.price);
  } catch (error) {
    console.error(`Error al obtener el precio de ${symbol}: ${error}`);
    throw error;
  }
}

// Función para acumular las ganancias o pérdidas en el estado del bot del usuario
function accumulateProfit(user, profit) {
  user.botState.totalProfit += profit;
}

// Función para realizar trading cuantitativo en un par de criptomonedas
async function performQuantitativeTrading(user, symbol, usdtAmount) {
  try {
    const historicalData = await getHistoricalData(symbol, '1h', 100);

    // Obtener los precios de cierre
    const closePrices = historicalData.map((data) => parseFloat(data[4]));

    // Calcular los indicadores técnicos utilizando TA-Lib
    const sma = talib.SMA(closePrices, 14);
    const rsi = talib.RSI(closePrices, 14);

    // Preparar los datos para el modelo de machine learning
    const features = [];
    for (let i = 0; i < closePrices.length; i++) {
      const feature = [sma[i], rsi[i]];
      features.push(feature);
    }

    // Cargar el modelo entrenado
    const modelPath = path.join(__dirname, 'trained_model.json');
    const readFile = promisify(fs.readFile);
    const modelJSON = await readFile(modelPath, 'utf8');
    const model = RandomForestClassifier.load(JSON.parse(modelJSON));

    // Predecir las señales utilizando el modelo
    const signals = model.predict(features);

    // Seleccionar las últimas señales y tomar una decisión de compra o venta
    const lastSignals = signals.slice(-2);
    const buySignal = lastSignals[0];
    const sellSignal = lastSignals[1];

    if (buySignal && !user.botState.position) {
      await performBuyOrder(user, symbol, usdtAmount);
      user.botState.position = 'long';
    } else if (sellSignal && user.botState.position === 'long') {
      await performSellOrder(user, symbol, usdtAmount);
      user.botState.position = null;
    } else {
      console.log('Señal neutral, no se realiza ninguna operación');
    }
  } catch (error) {
    console.error(`Error en el trading cuantitativo para el usuario ${user.id}: ${error}`);
  }
}

// Ruta para recibir los datos del formulario y realizar el trading cuantitativo
app.post('/quantitative-trading', async (req, res) => {
  const { userId, walletAmount, duration, walletAddress, publicKey, privateKey } = req.body;

  if (!users[userId]) {
    users[userId] = {
      capital: walletAmount,
      botState: {
        totalProfit: 0,
        position: null
      },
      walletAddress,
      publicKey,
      privateKey
    };
  }

  const topPairs = ['BTCUSDT', 'ETHUSDT', 'XRPUSDT', 'BCHUSDT', 'LTCUSDT'];
  for (const symbol of topPairs) {
    await performQuantitativeTrading(users[userId], symbol, walletAmount, duration);
  }

  await updateTronWallet(users[userId], users[userId].botState.totalProfit);

  res.status(200).json({ message: 'Trading cuantitativo finalizado' });
});



app.listen(3000, () => {
  console.log('Servidor iniciado en el puerto 3000');
});