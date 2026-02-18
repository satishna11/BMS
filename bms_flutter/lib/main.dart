import 'package:flutter/material.dart';
import 'screens/budget_screen.dart';
import 'screens/expense_screen.dart';
import 'screens/income_screen.dart';
import 'screens/report_screen.dart';
import 'screens/login_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    // Use MaterialApp with routes for Navigator
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Budget App',
      theme: ThemeData(primarySwatch: Colors.blue),
      // Start with login screen
      initialRoute: '/login',
      routes: {
        '/login': (context) => const LoginScreen(),
        '/dashboard': (context) => const DashboardScreen(),
        '/budget': (context) => const BudgetScreen(),
        '/expense': (context) => const ExpenseScreen(),
        '/income': (context) => const IncomeScreen(),
        '/report': (context) => const ReportScreen(),

        // ADD THESE 
        '/add-income': (context) => const IncomeScreen(),
        '/add-expense': (context) => const ExpenseScreen(),
        '/add-budget': (context) => const BudgetScreen(),
      },
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
                Navigator.pushNamed(context, '/budget');
              },
            ),
            ElevatedButton(
              child: const Text("Expense Screen"),
              onPressed: () {
                Navigator.pushNamed(context, '/expense');
              },
            ),
            ElevatedButton(
              child: const Text("Income Screen"),
              onPressed: () {
                Navigator.pushNamed(context, '/income');
              },
            ),
            ElevatedButton(
              child: const Text("Report Screen"),
              onPressed: () {
                Navigator.pushNamed(context, '/report');
              },
            ),
            const SizedBox(height: 20),
            ElevatedButton(
              child: const Text("Logout"),
              style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
              onPressed: () {
                // Navigate back to login
                Navigator.pushReplacementNamed(context, '/login');
              },
            ),
          ],
        ),
      ),
    );
  }
}
