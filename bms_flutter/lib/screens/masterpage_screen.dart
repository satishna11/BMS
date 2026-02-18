import 'package:bms_flutter/main.dart';
import 'package:bms_flutter/screens/budget_screen.dart';
import 'package:bms_flutter/screens/expense_screen.dart';
import 'package:bms_flutter/screens/income_screen.dart';
import 'package:bms_flutter/screens/report_screen.dart';
import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: const MasterPage(),
    );
  }
}

class MasterPage extends StatefulWidget {
  const MasterPage({super.key});

  @override
  State<MasterPage> createState() => _MasterPageState();
}

class _MasterPageState extends State<MasterPage> {
  int selectedIndex = 0;

  final List<Widget> pages = [
    const DashboardScreen(),
    const IncomeScreen(),
    const IncomeScreen(),
    const ExpenseScreen(),
    const ExpenseScreen(),
    const BudgetScreen(),
    const BudgetScreen(),
    const ReportScreen(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Row(
        children: [
          // Sidebar
          Container(
            width: 200,
            color: Colors.grey.shade300,
            child: ListView(
              children: [
                const SizedBox(height: 40),
                buildMenuItem('Dashboard', 0),
                const SizedBox(height: 20),
                buildMenuItem('Add Income', 1),
                buildMenuItem('View Income', 2),
                const SizedBox(height: 20),
                buildMenuItem('Add Expense', 3),
                buildMenuItem('View Expense', 4),
                const SizedBox(height: 20),
                buildMenuItem('Add Budget', 5),
                buildMenuItem('View Budget', 6),
                const SizedBox(height: 20),
                buildMenuItem('View Report', 7),
              ],
            ),
          ),

          // Main Content
          Expanded(
            child: Container(
              color: Colors.grey.shade100,
              child: pages[selectedIndex],
            ),
          ),
        ],
      ),
    );
  }

  Widget buildMenuItem(String title, int index) {
    return ListTile(
      title: Text(title),
      selected: selectedIndex == index,
      onTap: () {
        setState(() {
          selectedIndex = index;
        });
      },
    );
  }
}
