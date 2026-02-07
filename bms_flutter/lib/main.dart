import 'package:flutter/material.dart';
import 'screens/budget_screen.dart';
import 'screens/expense_screen.dart';
import 'screens/income_screen.dart';
import 'screens/report_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Budget App',
      theme: ThemeData(primarySwatch: Colors.blue),
      home: const DashboardScreen(), // Optional, or use BudgetScreen()
    );
  }
}

// Optional: simple dashboard as home
class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Dashboard")),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            ElevatedButton(
              child: const Text("Budget Screen"),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => const BudgetScreen()),
                );
              },
            ),
            ElevatedButton(
              child: const Text("Expense Screen"),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => const ExpenseScreen()),
                );
              },
            ),
            ElevatedButton(
              child: const Text("Income Screen"),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => const IncomeScreen()),
                );
              },
            ),
            ElevatedButton(
              child: const Text("Report Screen"),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => const ReportScreen()),
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
