import { Icon, Label, NativeTabs } from 'expo-router/unstable-native-tabs';
import { Platform } from 'react-native';
import { Tabs } from 'expo-router';
import { House } from 'lucide-react-native';
import { PlatformPressable } from '@react-navigation/elements';

export default function RootLayout() {

  const liquidGlass: boolean =
    Platform.OS === 'ios' && parseInt(Platform.Version.split('.')[0], 10) >= 26;

  return (
  <>
      {liquidGlass ? (
        <NativeTabs>
          <NativeTabs.Trigger name="index">
            <Label>Home</Label>
            <Icon sf="house.fill" md="home" />
          </NativeTabs.Trigger>
          <NativeTabs.Trigger name="settings">
            <Icon sf="gear" md="settings" />
            <Label>Settings</Label>
          </NativeTabs.Trigger>
        </NativeTabs >
      ) : (
        <Tabs
          screenOptions={{

            headerShown: true,
            tabBarButton: (props) => (
              <PlatformPressable
                {...props}
                onPress={(ev) => {
                  props.onPress?.(ev);
                }}
              />
            ),
          }}>
          <Tabs.Screen
            name="index"
            options={{
              title: 'Home',
              tabBarIcon: ({ color }) => <House size={24} color={color} />,
            }}
          />

          )
      }
